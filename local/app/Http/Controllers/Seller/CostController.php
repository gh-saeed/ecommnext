<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\PayMeta;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostController extends Controller
{
    public function all(){
        $startDayEn = verta()->startMonth()->formatGregorian('Y-m-d H:i:s');
        $endDayEn = verta()->endMonth()->formatGregorian('Y-m-d H:i:s');

        $products1 = Product::where('user_id',auth()->id())->latest()->pluck('id');
        $costMonth = Checkout::where('user_id',auth()->id())->where('type' , 0)->where('status' , 1)->whereBetween('created_at', [$startDayEn, $endDayEn])->sum('price');
        $profitsMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $payPriceMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum('price');
        $backsMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('cancel' , 1)->sum(DB::raw('price + carrier_price'));
        $paysMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $productsMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->where('cancel' , 0)->sum('count');
        $gatePayMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('method' , 0)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $walletPayMonth = PayMeta::whereIn('id',$products1)->whereBetween('created_at', [$startDayEn, $endDayEn])->where('method' , 1)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $carrierPriceMonth = PayMeta::whereIn('id',$products1)->where('status' , 100)->whereBetween('created_at', [$startDayEn, $endDayEn])->sum('carrier_price');

        $cost = Checkout::where('user_id',auth()->id())->where('type' , 0)->where('status' , 1)->sum('price');
        $profits = PayMeta::whereIn('id',$products1)->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $payPrice = PayMeta::whereIn('id',$products1)->where('status' , 100)->where('cancel' , 0)->sum('price');
        $backs = PayMeta::whereIn('id',$products1)->where('cancel' , 1)->sum(DB::raw('price + carrier_price'));
        $pays = PayMeta::whereIn('id',$products1)->where('status' , 100)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $products = PayMeta::whereIn('id',$products1)->where('status' , 100)->where('cancel' , 0)->sum('count');
        $gatePay = PayMeta::whereIn('id',$products1)->where('method' , 0)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $walletPay = PayMeta::whereIn('id',$products1)->where('method' , 1)->where('cancel' , 0)->sum(DB::raw('price + carrier_price'));
        $carrierPrice = PayMeta::whereIn('id',$products1)->where('status' , 100)->where('cancel' , 0)->sum('carrier_price');
        return view('seller.cost.all',compact('profits','carrierPrice','carrierPriceMonth','payPrice','backs','pays','products','cost','gatePay','walletPay','costMonth','profitsMonth','payPriceMonth','backsMonth','paysMonth','productsMonth','gatePayMonth','walletPayMonth'));
    }
    public function product(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $products = Product::where('user_id',auth()->id())->where("title", "LIKE", "%".$title."%")->latest()->paginate(30)->setPath($currentUrl);
        }
        else{
            $products = Product::where('user_id',auth()->id())->latest()->paginate(30)->setPath($currentUrl);
        }
        return view('seller.cost.product' , compact('products','title'));
    }
}
