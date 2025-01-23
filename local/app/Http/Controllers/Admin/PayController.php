<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Counseling;
use App\Models\Installments;
use App\Models\Loan;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\View;
use App\Models\Wallet;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    use SendSmsTrait;
    public function index(Request $request){
        $title = $request->title;
        if($request->pin){
            $pinPay = Pay::where('id' , $request->pin)->first();
            $pinPay->update([
                'pin' => $pinPay->pin ? 0 : 1
            ]);
            return redirect(url()->current().'?title='.$title);
        }
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $pays = Pay::where(function ($query) use($title) {
                $query->where('property', $title)
                    ->orWhere('id', $title)
                    ->orWhere('user_id', $title)
                    ->orWhere('deliver', $title);
            })->with('user')->with(["payMeta" => function($q){
                $q->with('product');
            }])->latest()->paginate(50)->setPath($currentUrl);
            $pined = [];
        }
        else{
            $pays = Pay::latest()->where('pin' , 0)->with('user')->with(["payMeta" => function($q){
                $q->with('product');
            }])->paginate(50)->setPath($currentUrl);
            $pined = Pay::latest()->where('pin' , 1)->with('user')->with(["payMeta" => function($q){
                $q->with('product');
            }])->get();
        }
        return view('admin.pay.index' , compact('pays','pined','title'));
    }

    public function returned(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $pp = Product::where("title", "LIKE", "%".$title."%")->pluck('id');
            $pays = PayMeta::where('status',2)->whereIn('product_id' , $pp)->has('product')->has('pay')->with('user')->latest()->paginate(50)->setPath($currentUrl);
        }
        else{
            $pays = PayMeta::where('status',2)->has('product')->has('pay')->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.pay.returned' , compact('pays','title'));
    }

    public function statisticsProduct(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $products = Product::where("title", "LIKE", "%".$title."%")->latest()->paginate(30)->setPath($currentUrl);
        }
        else{
            $products = Product::latest()->paginate(30)->setPath($currentUrl);
        }
        return view('admin.chart.product' , compact('products','title'));
    }

    public function edit(Pay $pay){
        $pays = Pay::where('id' , $pay->id)->with('address','user')->with(["payMeta" => function($q){
            $q->with('product');
        }])->first();
        $name = Setting::where('key' , 'name')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $products = Product::select(['title','id'])->latest()->take(500)->get();
        return view('admin.pay.show' , compact('pays','name','products','number'));
    }

    public function update(Pay $pay , Request $request){
        $user = User::where('id' , $pay['user_id'])->first();
        if($request->update == 1){
            Pay::where('id' , $pay->id)->first()->update([
                'status' => $request->status,
                'price' => $request->price
            ]);
            DB::table('pay_metas')->where('pay_id' , $pay->id)->update(['status' => $request->status]);
            if($request->status == 1 || $request->status == 2){
                $messageCancel = Setting::where('key' , 'messageCancel')->pluck('value')->first();
                DB::table('pay_metas')->where('pay_id' , $pay->id)->update(['cancel' => 1]);
                DB::table('checkouts')->whereIn('pay_id' , $pay->payMeta()->pluck('id'))->update(['status' => 2]);
                if($messageCancel){
                    if($user->number){
                        $this->sendSms($user->number , [$user->name , $pay->property],env('GHASEDAKAPI_Number'),$messageCancel);
                    }
                }
            }
        }
        if($request->update == 2){
            $messageStatus0 = Setting::where('key' , 'messageStatus0')->pluck('value')->first();
            $messageStatus1 = Setting::where('key' , 'messageStatus1')->pluck('value')->first();
            $messageStatus2 = Setting::where('key' , 'messageStatus2')->pluck('value')->first();
            $messageStatus3 = Setting::where('key' , 'messageStatus3')->pluck('value')->first();
            $payM = PayMeta::where('id',$request->payId)->first();
            $payM->update([
                'count' => $request->count,
                'time' => $request->time,
                'price' => $request->price,
                'carrier_price' => $request->carrier_price,
                'carrier_name' => $request->carrier_name,
                'track' => $request->track,
                'deliver' => $request->deliver,
                'cancel' => $request->cancel,
                'status' => $request->status,
            ]);

            $payMeta1 = $pay->payMeta()->where('cancel',0)->get();
            $deliverValues = range(0, 4);
            foreach ($deliverValues as $value) {
                if ($payMeta1->every(fn($product) => $product->deliver == $value)) {
                    $pay->update([
                        'deliver' => $value
                    ]);
                    break;
                }
            }

            if($request->status == 0 || $request->cancel == 1){
                DB::table('checkouts')->where('pay_id' , $payM->id)->update(['status' => 2]);
            }

            if($payM->cancel == 0){
                if($request->cancel == 1) {
                    $payM->pay()->update([
                        'price' => (int)$payM->pay()->pluck('price')->first() - (int)$payM->price - (int)$payM->carrier_price
                    ]);
                }
            }else{
                if($request->cancel == 0) {
                    $payM->pay()->update([
                        'price' => (int)$payM->pay()->pluck('price')->first() + (int)$payM->price + (int)$payM->carrier_price
                    ]);
                }
            }
            if($request->deliver == 1 && $messageStatus0){
                if($user->number){
                    $this->sendSms($user->number , [$user->name , $pay->property],env('GHASEDAKAPI_Number'),$messageStatus0);
                }
            }
            if($request->deliver == 2 && $messageStatus1){
                if($user->number){
                    $this->sendSms($user->number , [$user->name , $pay->property],env('GHASEDAKAPI_Number'),$messageStatus1);
                }
            }
            if($request->deliver == 3 && $messageStatus2){
                if($user->number){
                    $this->sendSms($user->number , [$user->name , $pay->property],env('GHASEDAKAPI_Number'),$messageStatus2);
                }
            }
            if($request->deliver == 4 && $messageStatus3){
                if($user->number){
                    $this->sendSms($user->number , [$user->name , $pay->property],env('GHASEDAKAPI_Number'),$messageStatus3);
                }
            }
            if($pay->payMeta()->where('cancel',0)->count() == 0){
                $pay->update([
                    'status' => 1
                ]);
            }
        }
        if($request->update == 3){
            $payM = PayMeta::where('id',$request->payId)->first();
            DB::table('checkouts')->where('pay_id' , $payM->id)->update(['status' => 1]);
        }
        if($request->update == 4){
            $messageBack = Setting::where('key' , 'messageBack')->pluck('value')->first();
            if($messageBack){
                if($user->number){
                    $this->sendSms($user->number , [$user->name , $pay->property , $pay->price],'',$messageBack);
                }
            }
            if($request->back == 1){
                $code = Wallet::buildCode();
                Wallet::create([
                    'price'=> $pay->price,
                    'type'=> 0,
                    'status'=> 100,
                    'property'=> $code,
                    'user_id'=> $pay->user_id,
                ]);
            }
            $pay->update([
                'back' => $request->back
            ]);
        }
        return 'success';
    }

    public function invoice(Pay $pay){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $logo = Setting::where('key' , 'logo')->pluck('value')->first();
        $address = Setting::where('key' , 'address')->pluck('value')->first();
        $email = Setting::where('key' , 'email')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $pays = Pay::with('address')->where('id',$pay->id)->with(["payMeta" => function($q){
            $q->with(["Product" => function($q){
                $q->with('user');
            }]);
        }])->with('user')->first();
        return view('admin.pay.invoice', compact(
            'pays',
            'title',
            'number',
            'email',
            'address',
            'logo',
        ));
    }

    public function print(Pay $pay){
        return view('admin.pay.print', compact(
            'pay',
        ));
    }

    public function create(){
        $users = User::latest()->take(500)->select(['name','id'])->get();
        $products = Product::latest()->take(500)->select(['title','id'])->get();
        return view('admin.pay.create', compact('users','products'));
    }

    public function addPay(Pay $pay , Request $request){
        PayMeta::create([
            'product_id' => $request->productM,
            'color' => $request->colorM,
            'size' => $request->sizeM,
            'count' => $request->countM,
            'guarantee' => $request->guaranteeM,
            'price' => $request->priceM,
            'user_id' => $pay->user_id,
            'status' => $pay->status,
            'pay_id' => $pay->id,
            'deliver' => $pay->deliver,
        ]);
        $pay->update([
            'price' => (int)$pay->price + (int)$request->priceM
        ]);
        return redirect()->back()->with([
            'message' => 'آیتم با موفقیت اضافه شد'
        ]);
    }

    public function group(Request $request){
        $pays = Pay::whereIn('id',explode(',',$request->pay))->get();
        return view('admin.pay.prints',compact('pays'));
    }

    public function createP(Request $request){
        $pay = Pay::create([
            'refId'=>'',
            'status'=>$request->status,
            'tax'=>$request->tax,
            'property'=>$request->property,
            'price'=>$request->price,
            'user_id'=>$request->user_id,
            'method' => $request->methods,
            'deliver' => $request->deliver,
            'track' => $request->track,
            'deposit' => $request->deposit??$request->price,
            'auth' => $request->property,
            'time' => '',
            'carrier'=> $request->carrier,
            'carrier_price'=> $request->carrier_price,
        ]);
        $address = Address::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'post'=> $request->post,
            'state'=> $request->state,
            'city'=> $request->city,
            'plaque'=> $request->plaque,
            'number'=> $request->number,
            'unit'=> $request->unit,
            'status'=> 0,
            'show'=> 0,
        ]);
        $pay->address()->attach($address->id);
        foreach (json_decode($request->metas) as $item){
            $payMeta = PayMeta::create([
                'product_id' => $item->product,
                'collect_id' => 0,
                'user_id'=>$request->user_id,
                'pay_id' => $pay->id,
                'prebuy' => 0,
                'discount_off'=> $request->discount_off,
                'status'=>$request->status,
                'price'=> $item->price,
                'count' => $item->count,
                'color' => $item->color,
                'size' => $item->size,
                'guarantee_name'=> $item->guarantee
            ]);
            $payMeta->address()->attach($address->id);
        }
        return 'success';
    }

    public function chart(Request $request){
        $date = $request->date;
        if($date == 0){
            $startDayEn = verta()->startDay()->formatGregorian('Y-m-d H:i:s');
            $endDayEn = verta()->endDay()->formatGregorian('Y-m-d H:i:s');
        }
        elseif($date == 1){
            $startDayEn = verta()->subDay(1)->startDay()->formatGregorian('Y-m-d H:i:s');
            $endDayEn = verta()->subDay(1)->endDay()->formatGregorian('Y-m-d H:i:s');
        }
        elseif($date == 2){
            $startDayEn = verta()->startWeek()->formatGregorian('Y-m-d H:i:s');
            $endDayEn = verta()->endWeek()->formatGregorian('Y-m-d H:i:s');
        }elseif($date == 3){
            $startDayEn = verta()->startMonth()->formatGregorian('Y-m-d H:i:s');
            $endDayEn = verta()->endMonth()->formatGregorian('Y-m-d H:i:s');
        }else{
            $startDayEn = verta()->startYear()->formatGregorian('Y-m-d H:i:s');
            $endDayEn = verta()->endYear()->formatGregorian('Y-m-d H:i:s');
        }
        $pay1 = Pay::whereBetween('created_at', [$startDayEn, $endDayEn])->whereNotIn('status' , [0,2,1])->count();
        $user1 = User::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $comment1 = Comment::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $income1 = Pay::whereBetween('created_at', [$startDayEn, $endDayEn])->whereNotIn('status' , [0,2,1])->pluck('price')->sum();
        $tickets1 = Ticket::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $views1 = View::whereBetween('created_at', [$startDayEn, $endDayEn])->count();

        $tops = Product::withCount(["payMeta" => function($q){
            $q->latest()->whereNotIn('status',[0,1]);
        }])->withCount(["payMeta as payMeta2" => function($q) use($startDayEn, $endDayEn){
            $q->latest()->whereBetween('created_at', [$startDayEn, $endDayEn])->whereNotIn('status',[0,1,2]);
        }])->orderBy('payMeta2','DESC' )->take(3)->get();

        $views = Product::withCount('view')->withCount(["view as view2" => function($q) use($startDayEn, $endDayEn){
            $q->latest()->whereBetween('created_at', [$startDayEn, $endDayEn]);
        }])->orderBy('view2','DESC' )->take(3)->get();

        $year2 =verta()->year;
        $farvardin = Verta::parse($year2 . ' فروردین 1')->formatGregorian('Y-m-d H:i:s');
        $ordibehesht = Verta::parse($year2 . ' اردیبهشت 1')->formatGregorian('Y-m-d H:i:s');
        $khordad = Verta::parse($year2 . ' خرداد 1')->formatGregorian('Y-m-d H:i:s');
        $tir = Verta::parse($year2 . ' تیر 1')->formatGregorian('Y-m-d H:i:s');
        $mordad = Verta::parse($year2 . ' مرداد 1')->formatGregorian('Y-m-d H:i:s');
        $shahrivar = Verta::parse($year2 . ' شهریور 1')->formatGregorian('Y-m-d H:i:s');
        $mehr = Verta::parse($year2 . ' مهر 1')->formatGregorian('Y-m-d H:i:s');
        $aban = Verta::parse($year2 . ' آبان 1')->formatGregorian('Y-m-d H:i:s');
        $azar = Verta::parse($year2 . ' آذر 1')->formatGregorian('Y-m-d H:i:s');
        $dey = Verta::parse($year2 . ' دی 1')->formatGregorian('Y-m-d H:i:s');
        $bahman = Verta::parse($year2 . ' بهمن 1')->formatGregorian('Y-m-d H:i:s');
        $esfand = Verta::parse($year2 . ' اسفند 1')->formatGregorian('Y-m-d H:i:s');

        $deyPrice = PayMeta::whereBetween('created_at', [$dey, $bahman])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $bahmanPrice = PayMeta::whereBetween('created_at', [$bahman, $esfand])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $esfandPrice = PayMeta::whereBetween('created_at', [$esfand, $farvardin])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $farvardinPrice = PayMeta::whereBetween('created_at', [$farvardin, $ordibehesht])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $ordibeheshtPrice = PayMeta::whereBetween('created_at', [$ordibehesht, $khordad])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $khordadPrice = PayMeta::whereBetween('created_at', [$khordad, $tir])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $tirPrice = PayMeta::whereBetween('created_at', [$tir, $mordad])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $mordadPrice = PayMeta::whereBetween('created_at', [$mordad, $shahrivar])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $shahrivarPrice = PayMeta::whereBetween('created_at', [$shahrivar, $mehr])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $mehrPrice = PayMeta::whereBetween('created_at', [$mehr, $aban])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $abanPrice = PayMeta::whereBetween('created_at', [$aban, $azar])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));
        $azarPrice = PayMeta::whereBetween('created_at', [$azar, $dey])->where('status' , 100)->where('cancel',0)->sum(DB::raw('price + carrier_price'));

        $deyUser = User::whereBetween('created_at', [$dey, $bahman])->count();
        $bahmanUser = User::whereBetween('created_at', [$bahman, $esfand])->count();
        $esfandUser = User::whereBetween('created_at', [$esfand, $farvardin])->count();
        $farvardinUser = User::whereBetween('created_at', [$farvardin, $ordibehesht])->count();
        $ordibeheshtUser = User::whereBetween('created_at', [$ordibehesht, $khordad])->count();
        $khordadUser = User::whereBetween('created_at', [$khordad, $tir])->count();
        $tirUser = User::whereBetween('created_at', [$tir, $mordad])->count();
        $mordadUser = User::whereBetween('created_at', [$mordad, $shahrivar])->count();
        $shahrivarUser = User::whereBetween('created_at', [$shahrivar, $mehr])->count();
        $mehrUser = User::whereBetween('created_at', [$mehr, $aban])->count();
        $abanUser = User::whereBetween('created_at', [$aban, $azar])->count();
        $azarUser = User::whereBetween('created_at', [$azar, $dey])->count();

        $deyPay = PayMeta::whereBetween('created_at', [$dey, $bahman])->where('status' , 100)->where('cancel' , 0)->count();
        $bahmanPay = PayMeta::whereBetween('created_at', [$bahman, $esfand])->where('status' , 100)->where('cancel' , 0)->count();
        $esfandPay = PayMeta::whereBetween('created_at', [$esfand, $farvardin])->where('status' , 100)->where('cancel' , 0)->count();
        $farvardinPay = PayMeta::whereBetween('created_at', [$farvardin, $ordibehesht])->where('status' , 100)->where('cancel' , 0)->count();
        $ordibeheshtPay = PayMeta::whereBetween('created_at', [$ordibehesht, $khordad])->where('status' , 100)->where('cancel' , 0)->count();
        $khordadPay = PayMeta::whereBetween('created_at', [$khordad, $tir])->where('status' , 100)->where('cancel' , 0)->count();
        $tirPay = PayMeta::whereBetween('created_at', [$tir, $mordad])->where('status' , 100)->where('cancel' , 0)->count();
        $mordadPay = PayMeta::whereBetween('created_at', [$mordad, $shahrivar])->where('status' , 100)->where('cancel' , 0)->count();
        $shahrivarPay = PayMeta::whereBetween('created_at', [$shahrivar, $mehr])->where('status' , 100)->where('cancel' , 0)->count();
        $mehrPay = PayMeta::whereBetween('created_at', [$mehr, $aban])->where('status' , 100)->where('cancel' , 0)->count();
        $abanPay = PayMeta::whereBetween('created_at', [$aban, $azar])->where('status' , 100)->where('cancel' , 0)->count();
        $azarPay = PayMeta::whereBetween('created_at', [$azar, $dey])->where('status' , 100)->where('cancel' , 0)->count();

        return view('admin.chart.index', compact(
            'pay1',
            'user1',
            'date',
            'comment1',
            'income1',
            'deyPrice',
            'tickets1',
            'views1',
            'views',
            'bahmanPrice',
            'esfandPrice',
            'farvardinPrice',
            'ordibeheshtPrice',
            'khordadPrice',
            'tirPrice',
            'tops',
            'mordadPrice',
            'shahrivarPrice',
            'mehrPrice',
            'abanPrice',
            'azarPrice',
            'deyUser',
            'bahmanUser',
            'esfandUser',
            'farvardinUser',
            'ordibeheshtUser',
            'khordadUser',
            'tirUser',
            'mordadUser',
            'shahrivarUser',
            'mehrUser',
            'abanUser',
            'azarUser',
            'deyPay',
            'bahmanPay',
            'esfandPay',
            'farvardinPay',
            'ordibeheshtPay',
            'khordadPay',
            'tirPay',
            'mordadPay',
            'shahrivarPay',
            'mehrPay',
            'abanPay',
            'azarPay',
        ));
    }

    public function delete(Pay $pay){
        $pay->address()->detach();
        DB::table('pay_metas')->where('pay_id', $pay->id)->delete();
        $pay->delete();
        return redirect()->back()->with([
            'message' => 'سفارش با موفقیت حذف شد'
        ]);
    }
}
