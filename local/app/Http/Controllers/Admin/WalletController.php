<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title || $title === 0){
            $wallets = Wallet::where('type' , $title)->latest()->with('user')->paginate(50)->setPath($currentUrl);
        }else{
            $wallets = Wallet::latest()->with('user')->paginate(50)->setPath($currentUrl);
        }
        $users = User::select(['name' , 'id'])->latest()->get();
        return view('admin.wallet.index' , compact('wallets','users'));
    }
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|max:220',
            'status' => 'required|max:220',
            'price' => 'required',
        ]);
        $code = Wallet::buildCode();
        Wallet::create([
            'refId' => 'بازگشت وجه',
            'price'=> $request->price,
            'type'=> $request->type,
            'status'=> $request->status,
            'property'=> $code,
            'user_id'=> $request->user_id,
        ]);
        return redirect()->back()->with([
            'message' => 'شارژ با موفقیت اضافه شد'
        ]);
    }
    public function edit(Wallet $wallet){
        return $wallet;
    }
    public function update(Wallet $wallet , Request $request){
        $request->validate([
            'user_id' => 'required|max:220',
            'status' => 'required|max:220',
            'price' => 'required',
        ]);
        $wallet->update([
            'price'=> $request->price,
            'type'=> $request->type,
            'status'=> $request->status,
            'user_id'=> $request->user_id,
        ]);
        return redirect()->back()->with([
            'message' => 'شارژ با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Wallet $wallet , Request $request){
        $wallet->delete();
        return redirect()->back()->with([
            'message' => 'شارژ با موفقیت حذف شد'
        ]);
    }
}
