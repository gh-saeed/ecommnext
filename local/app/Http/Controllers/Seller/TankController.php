<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tank;
use Illuminate\Http\Request;

class TankController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $tanks = Tank::where('parent_id' , 0)->where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->latest()->where('user_id',auth()->id())->paginate(50)->setPath($currentUrl);
        }else{
            $tanks = Tank::where('parent_id' , 0)->where('user_id',auth()->id())->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('seller.tank.index',compact('tanks','title'));
    }
    public function edit(Tank $tank,Request $request){
        $products = Product::latest()->where('user_id',auth()->id())->select(['title','id'])->get();
        $tanks = Tank::latest()->where('user_id',auth()->id())->where('parent_id' , $tank->id)->get();
        return view('seller.tank.show',compact('tank','tanks','products'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        Tank::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);
        return redirect()->back()->with([
            'message' => 'انبار اضافه شد'
        ]);
    }
    public function update(Tank $tank,Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $tank->update([
            'name' => $request->name
        ]);
        return redirect()->back()->with([
            'message' => 'انبار ویرایش شد'
        ]);
    }
    public function addTank(Request $request){
        $request->validate([
            'countTank' => 'required',
            'tank_id' => 'required',
            'typeTank' => 'required',
        ]);
        $tank = Tank::create([
            'count' => $request->countTank,
            'name' => $request->name,
            'product_id' => $request->post,
            'parent_id' => $request->tank_id,
            'type' => $request->typeTank,
            'user_id' => auth()->id()
        ]);
        return Tank::where('id' , $tank->id)->with('tanks')->first();
    }
    public function addDetail(Request $request){
        $request->validate([
            'count' => 'required',
            'tank_id' => 'required',
            'type' => 'required',
        ]);
        Tank::create([
            'count' => $request->count,
            'name' => $request->name ?? Product::where('id' , $request->product_id)->pluck('title')->first(),
            'product_id' => $request->product_id,
            'parent_id' => $request->tank_id,
            'type' => $request->type,
        ]);
        return redirect()->back()->with([
            'message' => 'جزییات اضافه شد'
        ]);
    }
    public function delete(Tank $tank){
        Tank::where('parent_id' , $tank->id)->delete();
        $tank->delete();
        return redirect()->back()->with([
            'message' => 'با موفقیت حذف شد'
        ]);
    }
}
