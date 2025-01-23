<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $carriers = Carrier::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->where('user_id',auth()->id())->paginate(50)->setPath($currentUrl);
        }else{
            $carriers = Carrier::select(['name' , 'id'])->where('user_id',auth()->id())->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('seller.carrier.index' , compact('carriers','title'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'price' => 'required|max:10',
            'limit' => 'required|max:10',
        ]);
        $post = Carrier::create([
            'name' => $request->name,
            'price' => $request->price,
            'limit' => $request->limit,
            'weight' => $request->weight,
            'user_id' => auth()->user()->id,
            'weightPrice' => $request->weightPrice,
        ]);
        return redirect()->back()->with([
            'message' => 'حامل با موفقیت اضافه شد'
        ]);
    }
    public function edit(Carrier $carrier){
        return Carrier::where('id' , $carrier->id)->first();
    }
    public function update(Carrier $carrier , Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'price' => 'required|max:10',
            'limit' => 'required|max:10',
        ]);
        $carrier->update([
            'name' => $request->name,
            'price' => $request->price,
            'limit' => $request->limit,
            'weight' => $request->weight,
            'weightPrice' => $request->weightPrice,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with([
            'message' => 'حامل ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Carrier $carrier){
        $carrier->delete();
        return redirect()->back()->with([
            'message' => 'حامل با موفقیت حذف شد'
        ]);
    }
}
