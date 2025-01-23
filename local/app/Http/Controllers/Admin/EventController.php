<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\SendMail;
use App\Models\Event;
use App\Models\Setting;
use App\Models\Subscribe;
use App\Models\User;
use Ghasedak\GhasedakApi;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function parent(){
        $events = Event::latest()->paginate(50);
        $users = User::latest()->select(['name','id'])->get();
        return view('admin.event.index',compact('events','users'));
    }
    public function sms(){
        $events = Event::where('type',1)->latest()->paginate(50);
        $users = User::where('number','!=',null)->latest()->select(['name','number','id'])->get();
        return view('admin.event.sms',compact('events','users'));
    }
    public function email(){
        $events = Event::where('type',2)->latest()->paginate(50);
        $users = User::where('email','!=',null)->latest()->select(['name','email','id'])->get();
        return view('admin.event.email',compact('events','users'));
    }
    public function subscribe(){
        $sub = Subscribe::latest()->paginate(50);
        return view('admin.event.subscribe',compact('sub'));
    }
    public function smsStore(Request $request){
        $request->validate([
            'body' => 'required',
            'title' => 'required',
            'pattern' => 'required',
            'user_id' => 'required',
        ]);
        foreach($request->user_id as $item){
            $users = User::where('id' , $item)->first();
            $smsType = Setting::where('key' , 'smsType')->pluck('value')->first();
            if($smsType == 0){
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify(
                    "$users->number",
                    "$request->pattern",
                    $users->name
                );
            }
            if($smsType == 1){
                $userSms = Setting::where('key' , 'userSms')->pluck('value')->first();
                $passSms = Setting::where('key' , 'passSms')->pluck('value')->first();
                $url = "https://api.payamak-panel.com/post/Send.asmx/SendByBaseNumber2?username=$userSms&password=$passSms&text=$users->name;&to=$users->number&bodyId=$request->pattern";
                $client = new Client();
                $response = $client->request('GET', $url,
                    [
                        'allow_redirects' => true
                    ]);
                $contents = $response->getBody()->getContents();
                $contents = json_decode($contents,true);
            }
            if($smsType == 2){
                $kaveKey = Setting::where('key' , 'kaveKey')->pluck('value')->first();
                $url = "https://api.kavenegar.com/v1/$kaveKey/verify/lookup.json?receptor=$users->number&token=$users->name&template=$request->pattern";
                $client = new Client();
                $response = $client->request('GET', $url,
                    [
                        'allow_redirects' => true
                    ]);
                $contents = $response->getBody()->getContents();
                $contents = json_decode($contents,true);
            }
            if($smsType == 3){
                $user = Setting::where('key' , 'userFaraz')->pluck('value')->first();
                $pass = Setting::where('key' , 'passFaraz')->pluck('value')->first();
                $fromNum = Setting::where('key' , 'numberFaraz')->pluck('value')->first();
                $toNum = array($users->number);
                $pattern_code = $request->pattern;
                $input_data = array(
                    "token" => $users->naem,
                );
                $url = 'https://ippanel.com/patterns/pattern?username=' . $user . '&password=' . urlencode($pass) . '&from='.$fromNum.'&to=' . json_encode($toNum) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code='.$pattern_code;
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($handler);
            }
            Event::create([
                'title' => $request->title,
                'body' => $request->body,
                'type' => 1,
                'user_id' => auth()->user()->id,
                'customer_id' => $users->id,
            ]);
        }
        return redirect()->back()->with([
            'message' => 'پیامک با موفقیت ارسال شد'
        ]);
    }
    public function emailStore(Request $request){
        $request->validate([
            'body' => 'required',
            'title' => 'required',
            'user_id' => 'required',
        ]);
        foreach($request->user_id as $item){
            $users = User::where('id' , $item)->first();
            SendEmailJob::dispatch($request->body , $request->title , $users->email);
            Event::create([
                'title' => $request->title,
                'body' => $request->body,
                'type' => 2,
                'user_id' => auth()->user()->id,
                'customer_id' => $users->id,
            ]);
        }
        return redirect()->back()->with([
            'message' => 'ایمیل با موفقیت ارسال شد'
        ]);
    }
    public function subscribeStore(Request $request){
        $request->validate([
            'email' => 'required',
        ]);
        Subscribe::create([
            'name' => $request->email
        ]);
        return redirect()->back()->with([
            'message' => 'ایمیل با موفقیت ثبت شد'
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'body' => 'required',
            'title' => 'required',
        ]);
        Event::create([
            'title' => $request->title,
            'body' => $request->body,
            'type' => 0,
            'user_id' => auth()->user()->id,
            'customer_id' => $request->user_id,
        ]);
        return redirect()->back()->with([
            'message' => 'اعلان با موفقیت اضافه شد'
        ]);
    }
    public function edit(Request $request){
        return Event::where('id' , $request->event)->first();
    }
    public function update(Request $request){
        $request->validate([
            'body' => 'required',
            'title' => 'required',
        ]);
        Event::where('id' , $request->event)->update([
            'title' => $request->title,
            'body' => $request->body,
            'type' => 100,
            'customer_id' => $request->user_id,
        ]);
        return redirect()->back()->with([
            'message' => 'اعلان با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request , Event $event){
        $event->delete();
        return redirect()->back()->with([
            'message' => 'اعلان با موفقیت حذف شد'
        ]);
    }
    public function subscribeDelete(Request $request , Subscribe $subscribe){
        $subscribe->delete();
        return redirect()->back()->with([
            'message' => 'ایمیل با موفقیت حذف شد'
        ]);
    }
}
