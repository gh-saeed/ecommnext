<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function selectAddress(Request $request){
        foreach (auth()->user()->address()->where('status', 1)->get() as $value) {
            Address::where('id' , $value['id'])->update([
                'status' => 0
            ]);
        }
        $myAddress = auth()->user()->address()->where('id' , $request->address)->where('show' , 1)->first();
        if($myAddress){
            $myAddress->update([
                'status' => 1
            ]);
            return redirect()->back()->with([
                'success' => __('messages.select_address2')
            ]);
        }else{
            return redirect()->back()->with([
                'message' => __('messages.no_address')
            ]);
        }
    }

    public function deleteAddress(Request $request){
        $address = auth()->user()->address()->where('id' , $request->id)->update([
            'show' => 0,
            'status' => 0,
        ]);
        return 'ok';
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'address' => 'required|max:255',
            'post' => 'required|max:10|min:10',
            'state' => 'required',
            'city' => 'required',
            'plaque' => 'required|max:4',
            'unit' => 'max:3',
            'number' => 'required|min:11|max:11',
        ]);
        auth()->user()->address()->update(array(
            'status' => 0,
        ));
        $address = Address::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'post'=> $request->post,
            'state'=> $request->state,
            'city'=> $request->city,
            'originLat'=> $request->originLat,
            'originLng'=> $request->originLng,
            'plaque'=> $request->plaque,
            'number'=> $request->number,
            'unit'=> $request->unit,
            'status'=> 1,
        ]);
        auth()->user()->address()->attach($address->id);
        return 'success';
    }

    public function editUserAddress(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'address' => 'required|max:255',
            'post' => 'required|max:10|min:10',
            'state' => 'required',
            'city' => 'required',
            'unit' => 'max:3',
            'plaque' => 'required|max:4',
            'number' => 'required|min:11|max:11',
        ]);
        DB::table('addresses')->where('status', 1)->update([
            'status' => 0
        ]);
        auth()->user()->address()->where('id' , $request->address_id)->where('show' , 1)->first()->update([
            'name'=> $request->name,
            'address'=> $request->address,
            'post'=> $request->post,
            'state'=> $request->state,
            'city'=> $request->city,
            'originLat'=> $request->originLat,
            'originLng'=> $request->originLng,
            'plaque'=> $request->plaque,
            'number'=> $request->number,
            'unit'=> $request->unit,
            'status'=> 1,
        ]);
        return 'success';
    }
}
