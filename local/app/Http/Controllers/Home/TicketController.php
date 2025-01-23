<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        return view('home.ticket.index');
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'status' => 'required',
            'answer' => 'required',
        ]);
        Ticket::create([
            'title'=>$request->title,
            'status'=>$request->status,
            'answer'=>$request->answer,
            'body'=>$request->body,
            'user_id'=>auth()->user()->id,
            'type'=>3,
        ]);
        return redirect()->back()->with([
            'success' => __('messages.request_back')
        ]);
    }
    public function closeChat(Request $request){
        Ticket::where('customer_id',\auth()->user()->id)->where(function ($query) use($request) {
            $query->where('parent_id' , $request->parent_id)
                ->orWhere('id', $request->parent_id);
        })->delete();
        return 'success';
    }
    public function sendTicket(Request $request){
        if(!auth()->user()){
            return redirect()->back()->with([
                'message' => __('messages.login_first')
            ]);
        }
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $year = Carbon::now()->year;
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year;
        if (!file_exists($folder)){
            mkdir($folder , 0755 , true);
        }
        $file1 = '';
        $file = $request->image;
        if($file&&$file != 'undefined'){
            $type = $file->getClientOriginalExtension();
            $name = time().'.'.$type;
            $sizefile = $file->getsize()/1000;
            if( $sizefile > 1000){
                $size=round($sizefile/1000 ,2) . 'mb';
            }else{
                $size=round($sizefile) . 'kb';
            }
            if ($type == "jpg" or $type == "JPG" or $type == "png" or $type == "PNG" or $type == "webp" or $type == "jpeg" or $type == "svg" or $type == "webp" or $type == "tif" or $type == "gif" or $type == "jfif"){
                $url = "/upload/image/" . $year;
            }
            elseif ($type == "mp3"){
                $url = "/upload/music/" . $year;
            }
            elseif ($type == "mp4" or $type == "mkv"){
                $url = "/upload/movie/" . $year;
            }
            else{
                $url = "/upload/file/" . $year;
            }
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
            $file1 = $img->url;
        }
        $ticket = Ticket::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'type'=>0,
            'status'=>$request->status??0,
            'parent_id'=>$request->parent_id??0,
            'customer_id'=>auth()->user()->id,
            'user_id'=>auth()->user()->id,
            'file'=>$file1,
        ]);
        if($request->faq){
            return $ticket;
        }
        return redirect()->back()->with([
            'success' => __('messages.show_ticket1')
        ]);
    }
    public function onlineTicket(Request $request){
        if(!auth()->user()){
            return '';
        }
        if($request->parent >= 1){
            return Ticket::where('user_id',\auth()->user()->id)->where('status' , 1)->where(function ($query) use($request) {
                $query->where('parent_id' , $request->parent)
                    ->orWhere('id', $request->parent);
            })->get();
        }else{
            $pp = Ticket::where('user_id',\auth()->user()->id)->where('customer_id',$request->seller)->where('status' , 1)->where('parent_id',0)->latest()->pluck('id')->first();
            return Ticket::where('user_id',\auth()->user()->id)->where('customer_id',$request->seller)->where('status' , 1)->where(function ($query) use($pp) {
                $query->where('parent_id' , $pp)
                    ->orWhere('id', $pp);
            })->get();
        }
    }
    public function chat(){
        $user = auth()->user();
        return view('home.profile.chat',compact('user'));
    }
    public function getChatParent(){
        return Ticket::latest()->where('status' , 1)->where(function ($query) {
            $query->where('user_id' , auth()->user()->id)
                ->orWhere('customer_id', auth()->user()->id);
        })->with('user')->where('parent_id' , 0)->get();
    }
    public function getChatTicket(Request $request){
        return Ticket::where('parent_id' , 0)->where(function ($query) {
            $query->where('user_id' , auth()->user()->id)
                ->orWhere('customer_id', auth()->user()->id);
        })->where('id' , $request->ticket)->with(["tickets" => function ($q) {
            $q->with('user');
        }])->with('user')->first();
    }
    public function sendChat(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $year = Carbon::now()->year;
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year;
        if (!file_exists($folder)){
            mkdir($folder , 0755 , true);
        }
        $file1 = '';
        $file = $request->image;
        if($file&&$file != 'undefined'){
            $type = $file->getClientOriginalExtension();
            $name = time().'.'.$type;
            $sizefile = $file->getsize()/1000;
            if( $sizefile > 1000){
                $size=round($sizefile/1000 ,2) . 'mb';
            }else{
                $size=round($sizefile) . 'kb';
            }
            if ($type == "jpg" or $type == "JPG" or $type == "png" or $type == "PNG" or $type == "webp" or $type == "jpeg" or $type == "svg" or $type == "webp" or $type == "tif" or $type == "gif" or $type == "jfif"){
                $url = "/upload/image/" . $year;
            }
            elseif ($type == "mp3"){
                $url = "/upload/music/" . $year;
            }
            elseif ($type == "mp4" or $type == "mkv"){
                $url = "/upload/movie/" . $year;
            }
            else{
                $url = "/upload/file/" . $year;
            }
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
            $file1 = $img->url;
        }
        Ticket::create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => 0,
            'type' => 0,
            'parent_id' => $request->parent ?? 0,
            'file' => $file1??null,
            'customer_id' => $request->customer_id ?? auth()->user()->id,
            'user_id' => auth()->user()->id,
        ]);
        return 'ok';
    }
    public function deleteChat(Request $request){
        return Ticket::latest()->where('status' , 1)->where(function ($query) {
            $query->where('user_id' , auth()->user()->id)
                ->orWhere('customer_id', auth()->user()->id);
        })->where(function ($query) use ($request) {
            $query->where('id' , $request->ticket)
                ->orWhere('parent_id', $request->ticket);
        })->delete();
    }
}
