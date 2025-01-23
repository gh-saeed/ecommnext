<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $title = $request->title;
        $status = $request->status;
        $currentUrl = url()->current().'?title='.$title.'&status='.$status;
        $checkouts = Checkout::latest()->when($title, function ($query) use($title) {
            return $query->where('price' , $title);
        })->when($status, function ($query) use($status) {
            return $query->where('status',$status);
        })->where('user_id',auth()->id())->where('type',0)->paginate(50)->setPath($currentUrl);
        $blockMoney = Checkout::where('user_id',auth()->id())->where('type',1)->where('status',0)->sum('price');
        $done = Checkout::where('user_id',auth()->id())->where('type',0)->where('status',1)->sum('price');
        $blockPay = Checkout::where('user_id',auth()->id())->where('type',1)->where('status',0)->count();
        return view('seller.checkout.checkout',compact('checkouts','title','done','status','blockPay','blockMoney'));
    }
    public function checkoutStore(Request $request)
    {
        $maxCharge = auth()->user()->myCheckout();
        $request->validate([
            'price' => 'required|integer|max:'.$maxCharge,
            'card' => 'required',
            'shaba' => 'required',
            'name' => 'required|max:100',
        ]);
        $code = Checkout::buildCode();
        Checkout::create([
            'price' => $request->price,
            'status' => 0,
            'type' => 0,
            'user_id' => auth()->id(),
            'card' => $request->card,
            'shaba' => $request->shaba,
            'name' => $request->name,
            'property' => $code,
        ]);
        return redirect('/seller/checkout')->with([
            'success' => 'درخواست با موفقیت ثبت شد'
        ]);
    }
}
