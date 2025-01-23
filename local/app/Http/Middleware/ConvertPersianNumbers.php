<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ConvertPersianNumbers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $request->merge($this->convertNumbersToEnglish($request->all()));

        return $next($request);
    }

    /**
     * Convert Persian and Arabic numbers to English numbers.
     *
     * @param  array  $data
     * @return array
     */
    protected function convertNumbersToEnglish(array $data): array
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return array_map(function ($item) use ($persianNumbers, $englishNumbers) {
            if (is_string($item)) {
                return str_replace($persianNumbers, $englishNumbers, $item);
            } elseif (is_array($item)) {
                return $this->convertNumbersToEnglish($item);
            }

            return $item;
        }, $data);
    }
}
