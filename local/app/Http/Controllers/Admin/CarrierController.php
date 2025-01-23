<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\CarrierCity;
use App\Models\User;
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
            })->select(['name','user_id' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $carriers = Carrier::select(['name' ,'user_id', 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        $users = User::where('seller','!=',0)->get(['name','id']);
        return view('admin.taxonomy.index.carrier' , compact('carriers','title','users'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'price' => 'required|max:10',
            'limit' => 'required|max:10',
        ]);
        $post = Carrier::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'limit' => $request->limit,
            'weight' => $request->weight,
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
            'user_id' => $request->user_id,
            'price' => $request->price,
            'limit' => $request->limit,
            'weight' => $request->weight,
            'weightPrice' => $request->weightPrice,
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
