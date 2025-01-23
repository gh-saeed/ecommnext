<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request){
        $title = $request->titleSearch;
        $currentUrl = url()->current().'?title='.$request->title;
        if($title){
            $discounts = Discount::where(function ($query) use($title) {
                $query->where('title', $title)
                    ->orWhere('id', $title);
            })->select(['title' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $discounts = Discount::select(['title' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        $products = Product::select(['title' , 'id'])->latest()->get();
        return view('admin.discount.index' , compact('discounts','products','title'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'code' => 'required',
            'day' => 'required',
            'percent' => 'required|integer|max:100',
            'count' => 'required|integer|max:100',
        ]);
        if($request->day){
            $ss =strtr($request->day, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
            $times = Verta::parse($ss)->toCarbon();
            $times2 = explode('T',$times);
            $day = implode(' ',$times2);
        }else{
            $day = null;
        }
        $post = Discount::create([
            'title'=> $request->title,
            'code'=> $request->code,
            'day'=> $day,
            'percent'=> $request->percent,
            'status'=> $request->status,
            'count'=> $request->count,
            'user_id'=> auth()->user()->id,
            'product_id'=> $request->product_id,
        ]);
        return redirect()->back()->with([
            'message' => 'کد تخفیف با موفقیت اضافه شد'
        ]);
    }
    public function edit(Discount $discount){
        if($discount->day){
            $day = verta($discount->day)->formatJalaliDatetime();
        }else{
            $day = '';
        }
        return [$discount , $day];
    }
    public function update(Discount $discount , Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'code' => 'required',
            'day' => 'required',
            'percent' => 'required|integer|max:100',
            'count' => 'required|integer|max:100',
        ]);
        if($request->day){
            $ss =strtr($request->day, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
            if($ss[0] != '2'){
                $times = Verta::parse($ss)->toCarbon();
                $times2 = explode('T',$times);
                $day = implode(' ',$times2);
            }else{
                $day = $ss;
            }
        }else{
            $day = null;
        }
        $discount->update([
            'title'=> $request->title,
            'code'=> $request->code,
            'day'=> $day,
            'percent'=> $request->percent,
            'status'=> $request->status,
            'count'=> $request->count,
            'user_id'=> auth()->user()->id,
            'product_id'=> $request->product_id,
        ]);
        return redirect()->back()->with([
            'message' => 'کد تخفیف ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Discount $discount){
        $discount->delete();
        return redirect()->back()->with([
            'message' => 'کد تخفیف با موفقیت حذف شد'
        ]);
    }
}
