<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title', $title)
                    ->orWhere('id', $title);
            })->select(['id' , 'title' ,'price' , 'image' , 'count','colors','size'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $products = Product::select(['id' , 'title' ,'price' , 'image' , 'count','colors','size'])->latest()->paginate(50)->setPath($currentUrl);
        }
        $inventory = 1;
        return view('admin.inventory.index',compact('products' , 'inventory','title'));
    }
    public function inquiry(Request $request){
        $carts = Cart::where('inquiry' , 0)->with('product','user')->get();
        return view('admin.inventory.inquiry',compact('carts'));
    }
    public function inquiryChange(Request $request){
        Cart::where('id' , $request->post)->update([
            'inquiry' => $request->status
        ]);
        return 'ok';
    }
    public function empty(Request $request){
        $title = $request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title', $title)
                    ->orWhere('id', $title);
            })->where('count' , 0)->select(['id' , 'title' ,'price' , 'image' , 'count','colors','size'])->latest()->paginate(100);
        }else{
            $products = Product::select(['id' , 'title' ,'price' , 'image' , 'count','colors','size'])->where('count' , 0)->latest()->paginate(100);
        }
        $inventory = 0;
        return view('admin.inventory.index',compact('products','inventory','title'));
    }
}
