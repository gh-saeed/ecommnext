<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counseling;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('admin.ticket.index',compact('user'));
    }
    public function getTicketParent(){
        return Ticket::latest()->where('status' , 0)->has('user')->with('user')->where('parent_id' , 0)->get();
    }
    public function chat(){
        $user = auth()->user();
        return view('admin.ticket.chat',compact('user'));
    }
    public function getChatParent(){
        return Ticket::latest()->where('status' , 1)->has('user')->with('user')->where('parent_id' , 0)->get();
    }
    public function getChatTicket(Request $request){
        return Ticket::where('parent_id' , 0)->has('user')->where('id' , $request->ticket)->with(["tickets" => function ($q) {
            $q->with('user');
        }])->with('user')->first();
    }
    public function sendTicket(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $user_id = 0;
        if($request->parent){
            $parent = Ticket::where('status' , 0)->where('parent_id' , 0)->where('id' , $request->parent)->first();
            $user_id = $parent->customer_id;
            $check1 = Ticket::where('status' , 1)->where('parent_id' , $request->parent)->first();
            if(!$check1){
                $messageTicket = Setting::where('key' , 'messageTicket')->pluck('value')->first();
                if($messageTicket){
                    $uu = User::where('id', $parent->customer_id)->first();
                    if($uu->number){
                        $this->sendSms($uu->number , [$uu->name],'',$messageTicket);
                    }
                }
            }
        }
        Ticket::create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => 0,
            'type' => 0,
            'parent_id' => $request->parent ?? 0,
            'file' => $request->file_id??null,
            'customer_id' => $user_id,
            'user_id' => auth()->user()->id,
        ]);
        if($request->parent){
            return 'ok';
        }else{
            $number = Setting::where('key' , 'number')->pluck('value')->first();
            $messageTicket = Setting::where('key' , 'messageTicket')->pluck('value')->first();
            if($messageTicket){
                if($number){
                    $this->sendSms($number , [auth()->user()->name],'',$messageTicket);
                }
            }
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
            $check1 = Ticket::where('status' , 1)->where('parent_id' , $request->parent)->first();
            if(!$check1){
                $messageTicket = Setting::where('key' , 'messageTicket')->pluck('value')->first();
                if($messageTicket){
                    $uu = User::where('id', $parent->customer_id)->first();
                    if($uu->number){
                        $this->sendSms($uu->number , [$uu->name],'',$messageTicket);
                    }
                }
            }
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
