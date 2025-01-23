<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        if(!$user){
            return 'noUser';
        }
        $like = Like::where('product_id' , $request->product)->where('user_id' , $user->id)->first();
        if($like){
            $like->delete();
            return 'delete';
        }else{
            $like = Like::create([
                'user_id'=>$user->id,
                'product_id'=>$request->product,
            ]);
            return 'success';
        }
    }
}
