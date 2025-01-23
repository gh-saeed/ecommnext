<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title || $title === 0){
            $checkouts = Checkout::where('type' , $title)->where('type',0)->latest()->with('user')->paginate(50)->setPath($currentUrl);
        }else{
            $checkouts = Checkout::latest()->where('type',0)->with('user')->paginate(50)->setPath($currentUrl);
        }
        $users = User::select(['name' , 'id'])->latest()->get();
        $products = Product::select(['title' , 'id'])->latest()->get();
        return view('admin.checkout.index' , compact('checkouts','users','products'));
    }
    public function store(Request $request){
        $request->validate([
            'price' => 'required|integer',
            'card' => 'required|digits: 16',
            'shaba' => 'required|digits: 24',
            'name' => 'required|max:100',
        ]);
        $code = Checkout::buildCode();
        Checkout::create([
            'name'=> $request->name,
            'price'=> $request->price,
            'card'=> $request->card,
            'shaba'=> $request->shaba,
            'status'=> $request->status,
            'property'=> $code,
            'user_id'=> $request->user_id,
            'type'=> $request->type,
            'user_ip'=> $request->user_ip,
        ]);
        return redirect()->back()->with([
            'message' => 'تسویه با موفقیت اضافه شد'
        ]);
    }
    public function edit(Checkout $checkout){
        return $checkout;
    }
    public function update(Checkout $checkout , Request $request){
        $request->validate([
            'price' => 'required|integer',
            'card' => 'required|digits: 16',
            'shaba' => 'required|digits: 24',
            'name' => 'required|max:100',
        ]);
        $checkout->update([
            'name'=> $request->name,
            'price'=> $request->price,
            'card'=> $request->card,
            'shaba'=> $request->shaba,
            'status'=> $request->status,
            'user_id'=> $request->user_id,
            'type'=> $request->type,
            'user_ip'=> $request->user_ip,
        ]);
        return redirect()->back()->with([
            'message' => 'تسویه با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Checkout $checkout , Request $request){
        $checkout->delete();
        return redirect()->back()->with([
            'message' => 'تسویه با موفقیت حذف شد'
        ]);
    }
}
