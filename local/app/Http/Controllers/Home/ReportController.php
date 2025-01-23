<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function sendReport(Request $request){
        if(auth()->user()){
            Report::create([
                'user_id' => Auth::id(),
                'data' => $request->datas,
                'reportable_id' => $request->product_id,
                'reportable_type'=> 'App\\Models\\Product',
            ]);
            return 'success';
        }else{
            return 'noUser';
        }
    }
}
