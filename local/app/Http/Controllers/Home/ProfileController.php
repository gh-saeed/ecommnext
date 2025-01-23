<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Counseling;
use App\Models\Discount;
use App\Models\Gallery;
use App\Models\Pay;
use App\Models\Product;
use App\Models\Score;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function ChangeAllUserInfo(Request $request){
        $request->validate([
            'name' => 'required|max:255',
        ]);
        if($request->password){
            auth()->user()->update([
                'password'=>Hash::make($request->password),
                'name'=>$request->name,
                'landingPhone'=>$request->landingPhone,
                'shaba'=>$request->shaba,
                'body'=>$request->body,
            ]);
        }else{
            auth()->user()->update([
                'name'=>$request->name,
                'landingPhone'=>$request->landingPhone,
                'shaba'=>$request->shaba,
                'body'=>$request->body,
            ]);
        }
        return redirect()->back()->with([
            'message' => __('messages.user_edited')
        ]);
    }
    public function profile(){
        $pays = Pay::latest()->where('user_id' , auth()->user()->id)->take(10)->get();
        return view('home.profile.index', compact('pays'));
    }
    public function pay(Request $request){
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        if($request->show == 0){
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->paginate($showPostPage);
        }
        if($request->show == 1){
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('status' , 100)->paginate($showPostPage);
        }
        if($request->show == 2){
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('status' , '!=' , 100)->paginate($showPostPage);
        }
        if($request->show == 3){
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('deliver' , 1)->paginate($showPostPage);
        }
        if($request->show == 4){
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('deliver' , 0)->paginate($showPostPage);
        }
        return view('home.profile.pay', compact('pays'));
    }
    public function like(){
        $likes =  auth()->user()->like;
        $likePost = [];
        foreach ($likes as $item) {
            $posts = Product::latest()->where('id' , $item->product_id)->pluck('id')->first();
            array_push($likePost , $posts);
        }

        $title = __('messages.like_user');
        $likePosts = Product::latest()->whereIn('id' , $likePost)->get();
        $tab = 2;
        return view('home.profile.like', compact('likePosts','title','tab'));
    }
    public function comment(Request $request){
        $comments = Comment::where('user_id' , auth()->user()->id)->with('product')->get();
        return view('home.profile.comment', compact('comments'));
    }
    public function personalInfo(){
        $user = User::where('id' , auth()->user()->id)->first();
        return view('home.profile.info', compact('user'));
    }
    public function ticket(){
        $tickets = Ticket::where('customer_id',\auth()->user()->id)->where('parent_id' , 0)->where('status' , 0)->get();
        return view('home.profile.ticket', compact('tickets'));
    }
    public function subcategory(){
        $address = Setting::where('key' , 'address')->pluck('value')->first();
        $users = User::where('parent_id' , auth()->user()->referral)->withCount(["cooperation" => function ($q) {
            $q->where('status' , 100)->where('type' , 0)->select(DB::raw('sum(price)'));
        }])->get();
        $referralUser = User::where('referral' , auth()->user()->parent_id)->get();
        return view('home.profile.subcategory', compact('users','referralUser','address'));
    }

    public function removeTicket(Ticket $ticket){
        $tickets = Ticket::where('user_id' , auth()->user()->id)->where('id' , $ticket->id)->first();
        if($tickets){
            $tickets->delete();
            return redirect()->back()->with([
                'message' => __('messages.ticket_deleted')
            ]);
        }else{
            return redirect()->back()->with([
                'message' => __('messages.no_ticket')
            ]);
        }
    }

    public function showPay(Pay $pay){
        $pays = Pay::where('id' , $pay->id)->with('address','user')->with(["payMeta" => function($q){
            $q->with('product');
        }])->first();
        $name = Setting::where('key' , 'name')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        return view('home.profile.show' , compact('pays','name','number'));
    }

    public function invoice(Pay $pay){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $logo = Setting::where('key' , 'logo')->pluck('value')->first();
        $address = Setting::where('key' , 'address')->pluck('value')->first();
        $email = Setting::where('key' , 'email')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $pays = Pay::with('address')->where('id',$pay->id)->with(["payMeta" => function($q){
            $q->with(["Product" => function($q){
                $q->with('user');
            }]);
        }])->with('user')->first();
        return view('admin.pay.invoice', compact(
            'pays',
            'title',
            'number',
            'email',
            'address',
            'logo',
        ));
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function uploadProfile(Request $request){
        $folder = $_SERVER['DOCUMENT_ROOT']."/upload/user/" . auth()->user()->id . '/';
        if (!file_exists($folder)){
            mkdir($folder , 0755 , true);
        }
        $file = $request->image;
        $name = $file->getClientOriginalName();
        $type = $file->getClientOriginalExtension();
        $sizefile = $file->getsize()/1000;
        if( $sizefile > 1000){
            $size=round($sizefile/1000 ,2) . 'mb';
        }else{
            $size=round($sizefile) . 'kb';
        }
        $url = "/upload/user/" . auth()->user()->id;
        if ($type == "jpg" or $type == "JPG" or $type == "png" or $type == "PNG" or $type == "jpeg" or $type == "svg" or $type == "tif" or $type == "gif" or $type == "jfif"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "rar" or $type == "zip"){
            $path = $file->move(storage_path($url) , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "mp3"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "mp4" or $type == "mkv"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'user_id' => auth()->user()->id,
                'type' => $type,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        auth()->user()->update([
            'profile' => $img['url']
        ]);
        return 'success';
    }
}
