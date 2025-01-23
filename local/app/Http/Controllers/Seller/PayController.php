<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $pays = Pay::whereHas('myPayMeta')->where(function ($query) use($title) {
                $query->where('property', $title)
                    ->orWhere('id', $title);
            })->with('user')->with(["myPayMeta" => function($q){
                $q->with('product');
            }])->latest()->paginate(50)->setPath($currentUrl);
        }
        else{
            $pays = Pay::whereHas('myPayMeta')->latest()->with('user')->with(["myPayMeta" => function($q){
                $q->with('product');
            }])->paginate(50)->setPath($currentUrl);
        }
        return view('seller.pay.index' , compact('pays','title'));
    }

    public function edit(Pay $pay){
        $pays = Pay::where('id' , $pay->id)->with('address','user')->first();
        $name = Setting::where('key' , 'name')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        return view('seller.pay.show' , compact('pays','name','number'));
    }

    public function update(Pay $pay , Request $request){
        $payMeta = $pay->myPayMeta()->where('id',$request->payId)->first();
        $payMeta->update([
            'track' => $request->track,
            'deliver' => $request->deliver
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
        return 'success';
    }

    public function returned(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $pp = Product::where("title", "LIKE", "%".$title."%")->where('user_id',auth()->user()->id)->pluck('id');
            $pays = PayMeta::where('cancel',1)->whereIn('product_id' , $pp)->has('product')->has('pay')->with('user')->latest()->paginate(50)->setPath($currentUrl);
        }
        else{
            $pays = PayMeta::where('cancel',1)->has('product')->whereIn('product_id',Product::where('user_id',auth()->user()->id)->pluck('id'))->has('pay')->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('seller.pay.returned' , compact('pays','title'));
    }

    public function invoice(Pay $pay){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $logo = Setting::where('key' , 'logo')->pluck('value')->first();
        $address = Setting::where('key' , 'address')->pluck('value')->first();
        $email = Setting::where('key' , 'email')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $pays = Pay::with('address')->where('id',$pay->id)->with(["myPayMeta" => function($q){
            $q->with(["Product" => function($q){
                $q->with('user');
            }]);
        }])->with('user')->first();
        return view('seller.pay.invoice', compact(
            'pays',
            'title',
            'number',
            'email',
            'address',
            'logo',
        ));
    }
    public function group(Request $request){
        $pays = Pay::whereHas('myPayMeta')->whereIn('property',explode(',',$request->pay))->get();
        return view('admin.pay.prints',compact('pays'));
    }
}
