<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Wallet;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(){
        $posts = Product::latest()->where('user_id' , auth()->user()->id)->pluck('id');
        $pays = PayMeta::latest()->whereIn('product_id' , $posts)->where('status' , 100)->with('product','pay','user')->take(10)->get();
        $paycount = Checkout::latest()->where('user_id' , auth()->id())->where('type' , 1)->whereIn('status' , [0,1])->sum('price');
        $postcount = Product::latest()->where('user_id' , auth()->user()->id)->count();
        $checksum = Checkout::latest()->where('user_id' , auth()->id())->where('type' , 0)->where('status' , 1)->sum('price');
        $posts = Product::latest()->where('user_id' , auth()->user()->id)->where('type',0)->take(10)->get();
        return view('seller.index',compact('pays','paycount','postcount','checksum','posts'));
    }
}
