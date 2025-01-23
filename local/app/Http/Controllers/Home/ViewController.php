<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ViewController extends Controller
{
    public function view(Request $request){
        $agent = new Agent();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $user_ip = $request->ip();
        $type = $request->type == 0 ? 'App\\Models\\Product' : '';
        $views = View::where('user_ip' , $user_ip)->where('viewable_id',$request->productId)->where('viewable_type' , $type)->whereDate('created_at' , Carbon::today())->get()->first();
        if (!$views){
            View::create([
                'browser'=>$browser,
                'platform'=>$platform,
                'user_ip'=>$user_ip,
                'user_id'=>auth()->user()?auth()->user()->id:0,
                'viewable_id'=>$request->productId,
                'viewable_type'=> $type,
            ]);
        }
    }
}
