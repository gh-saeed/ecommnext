<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        $tickets = Ticket::where(function ($query){
            $query->where("customer_id", auth()->user()->id)
                ->orWhere("user_id", auth()->user()->id);
        })->latest()->where('parent_id' , 0)->where('status' , 0)->get();
        return view('seller.ticket.index',compact('tickets'));
    }
    public function getTicketParent(Request $request){
        return Ticket::where('parent_id' , 0)->where('id' , $request->ticket)->with(["tickets" => function ($q) {
            $q->with('user');
        }])->with('user')->first();
    }
    public function chat(){
        $user = auth()->user();
        return view('seller.ticket.chat',compact('user'));
    }
    public function getChatParent(){
        return Ticket::latest()->where('status' , 1)->with('user')->where('parent_id' , 0)->get();
    }
    public function getChatTicket(Request $request){
        return Ticket::where('parent_id' , 0)->where('id' , $request->ticket)->with(["tickets" => function ($q) {
            $q->with('user');
        }])->with('user')->first();
    }
    public function sendTicket(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $user_id = 0;
        if($request->parent_id){
            $parent = Ticket::where('status' , 0)->where('parent_id' , 0)->where('id' , $request->parent_id)->first();
            $user_id = $parent->customer_id;
        }
        Ticket::create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => 0,
            'type' => 0,
            'parent_id' => $request->parent_id ?? 0,
            'file' => $request->file_id??null,
            'customer_id' => $user_id,
            'user_id' => auth()->user()->id,
        ]);
        if($request->parent_id){
            return 'ok';
        }
        return redirect()->back()->with([
            'message' => 'تیکت با موفقیت ایجاد شد'
        ]);
    }
    public function sendChat(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $user_id = 0;
        if($request->parent){
            $parent = Ticket::where('status' , 1)->where('parent_id' , 0)->where('id' , $request->parent)->first();
            $user_id = $parent->customer_id;
        }
        Ticket::create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => 1,
            'type' => 0,
            'parent_id' => $request->parent ?? 0,
            'file' => $request->file_id??null,
            'customer_id' => $user_id,
            'user_id' => auth()->user()->id,
        ]);
        if($request->parent){
            return 'ok';
        }
        return redirect()->back()->with([
            'message' => 'تیکت با موفقیت ایجاد شد'
        ]);
    }
    public function deleteChat(Request $request){
        Ticket::where(function ($query) use($request) {
            $query->where('parent_id' , $request->ticket)
                ->orWhere('id', $request->ticket);
        })->delete();
        return 'ok';
    }
}
