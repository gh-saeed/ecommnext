<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Pay;
use App\Models\PayMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostController extends Controller
{
    public function statistics(){
        $startDayEn = verta()->startMonth()->formatGregorian('Y-m-d H:i:s');
        $endDayEn = verta()->endMonth()->formatGregorian('Y-m-d H:i:s');

        $costMonth = Checkout::where('type' , 0)->where('status' , 1)->whereBetween('created_at', [$startDayEn, $endDayEn])->sum('price');
        $profitsMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $payPriceMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum('price');
        $backsMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('cancel' , 1)->sum(DB::raw('price + carrier_price'));
        $paysMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $productsMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum('count');
        $gatePayMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('method' , 0)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $walletPayMonth = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('method' , 1)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $carrierPriceMonth = PayMeta::where('status' , 100)->whereBetween('created_at', [$startDayEn, $endDayEn])->sum('carrier_price');

        $cost = Checkout::where('type' , 0)->where('status' , 1)->sum('price');
        $profits = PayMeta::where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $payPrice = PayMeta::where('status' , 100)->where('cancel' , 0)->sum('price');
        $backs = PayMeta::where('cancel' , 1)->sum(DB::raw('price + carrier_price'));
        $pays = PayMeta::where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $products = PayMeta::where('status' , 100)->where('cancel' , 0)->sum('count');
        $gatePay = PayMeta::where('method' , 0)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $walletPay = PayMeta::where('method' , 1)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $carrierPrice = PayMeta::where('status' , 100)->where('cancel' , 0)->sum('carrier_price');
        return view('admin.cost.statistics',compact('profits','carrierPrice','carrierPriceMonth','payPrice','backs','pays','products','cost','gatePay','walletPay','costMonth','profitsMonth','payPriceMonth','backsMonth','paysMonth','productsMonth','gatePayMonth','walletPayMonth'));
    }
}
