<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()){
            if(auth()->user()->seller != 0){
                if(!auth()->user()->documentSuccess){
                    auth()->user()->update([
                        'seller' => 0
                    ]);
                }else{
                    return $next($request);
                }
            }
        }
        return redirect('/login');
    }
}
