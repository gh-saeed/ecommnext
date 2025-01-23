<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class NotExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $checkInstall = file_exists(storage_path('installed'));
        if($checkInstall){
            $redirect = Redirect::where(function ($query){
                $query->where('start' , urlencode(request()->url()))
                    ->orWhere('start', request()->url());
            })->first();
            if($redirect){
                if($redirect->type == 0){
                    return redirect($redirect->end);
                }else{
                    if ($redirect->type == 410){
                        return response()->view('errors.410', [], 410);
                    }else{
                        return redirect($redirect->end,$redirect->type);
                    }
                }
            }
            $redirectStatus = Setting::where('key' , 'redirectStatus')->pluck('value')->first();
            $newRedirect = Setting::where('key' , 'newRedirect')->pluck('value')->first();
            if($response->getContent() != null){
                if ($response->status() == 404 && $redirectStatus) {
                    return redirect($newRedirect);
                }
            }
        }
        return $response;
    }
}
