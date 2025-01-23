<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rate;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function sendComment(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'rate' => 'required',
        ]);
        if(!auth()->user()){
            return 'noUser';
        }
        $comment = Comment::create([
            'product_id' => $request->product,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'rate' => $request->rate,
            'type' => $request->type,
            'bad' => $request->bad,
            'good' => $request->good,
        ]);
        return 'success';
    }
}
