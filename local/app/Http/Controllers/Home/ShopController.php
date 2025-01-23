<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\SendMail;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Discount;
use App\Models\Guarantee;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Score;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use stringEncode\Exception;

class ShopController extends Controller
{
    use SendSmsTrait;
    public function add_order(Request $request)
    {
        $time = Carbon::now()->format('Y-m-d h:i:s');
        $choicePay = $request->gateway;
        $address = auth()->user()->address()->where('status' , 1)->first();
        if(!$address){
            return redirect()->back()->with([
                'message' => __('messages.select_address5')
            ]);
        }
        $getData = $this->getCart();
        if (auth()->user()->cart()->where('number' , 0)->count() >= 1) {
            $count = Cart::where('user_id' , auth()->user()->id)->where('number' , 0)->get();

            $amount = 0;
            for ( $i = 0; $i < count($count); $i++) {
                $allSum2 = ((int)$count[$i]['price'] - (int)$count[$i]['carrier_price']) * (int)$count[$i]['count'];
                $amount += (int)$allSum2;
                if($count[$i]->discount){
                    $discount = Discount::where('code' , $count[$i]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('count' , '>=' , 1)->first();
                    if ($discount) {
                        if($discount['day']){
                            $discount = Discount::where('code' , $count[$i]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                        }
                        $discount->update([
                            'count'=> $discount->count - 1
                        ]);
                        if($count[$i]['product_id'] == $discount['product_id']){
                            $amount = $amount - (($amount * $discount->percent) / 100);
                        }
                    }
                }
            }

            if($count[0]->discount){
                $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , null)->where('status' , 1)->where('count' , '>=' , 1)->first();
                if($discount){
                    if($discount['day']){
                        $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , null)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                    }
                    $discount->update([
                        'count'=> $discount->count - 1
                    ]);
                    $amount = $amount - ($amount * $discount->percent) / 100;
                }
            }

            $tax = Setting::where('key' , 'tax')->pluck('value')->first() ?? 0;
            $amount = $amount + (($amount * $tax) / 100);

            $amount += $getData[1];

            if($choicePay == 0){
                $merchantId = Setting::where('key' , 'zarinpal')->pluck('value')->first();
                $gate = 'zarinpal';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 1){
                $merchantId = Setting::where('key' , 'zibal')->pluck('value')->first();
                $gate = 'zibal';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 2){
                $merchantId = Setting::where('key' , 'nextPay')->pluck('value')->first();
                $gate = 'nextpay';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 3){
                $merchantId = Setting::where('key' , 'idpay')->pluck('value')->first();
                $gate = 'idpay';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 4){
                $terminalBeh = Setting::where('key' , 'terminalBeh')->pluck('value')->first();
                $userBeh = Setting::where('key' , 'userBeh')->pluck('value')->first();
                $passwordBeh = Setting::where('key' , 'passwordBeh')->pluck('value')->first();
                $gate = 'behpardakht';
                $configs = [
                    'terminalId' => $terminalBeh,
                    'username' => $userBeh,
                    'password' => $passwordBeh,
                ];
            }
            if($choicePay == 5){
                $keySadad = Setting::where('key' , 'keySadad')->pluck('value')->first();
                $merchantSadad = Setting::where('key' , 'merchantSadad')->pluck('value')->first();
                $terminalSadad = Setting::where('key' , 'terminalSadad')->pluck('value')->first();
                $gate = 'sadad';
                $configs = [
                    'key' => $keySadad,
                    'merchantId' => $merchantSadad,
                    'terminalId' => $terminalSadad,
                ];
            }
            if($choicePay == 6){
                $terminalAsan = Setting::where('key' , 'terminalAsan')->pluck('value')->first();
                $userAsan = Setting::where('key' , 'userAsan')->pluck('value')->first();
                $passwordAsan = Setting::where('key' , 'passwordAsan')->pluck('value')->first();
                $gate = 'asanpardakht';
                $configs = [
                    'username' => $userAsan,
                    'password' => $passwordAsan,
                    'merchantConfigID' => $terminalAsan,
                ];
            }
            if($choicePay == 7){
                $merchantPasargad = Setting::where('key' , 'merchantPasargad')->pluck('value')->first();
                $terminalPasargad = Setting::where('key' , 'terminalPasargad')->pluck('value')->first();
                $certificatePasargad = Setting::where('key' , 'certificatePasargad')->pluck('value')->first();
                $gate = 'pasargad';
                $configs = [
                    'merchantId' => $merchantPasargad,
                    'terminalCode' => $terminalPasargad,
                    'certificate' => $certificatePasargad,
                ];
            }
            if($choicePay == 8){
                $merchantSaman = Setting::where('key' , 'samansep')->pluck('value')->first();
                $gate = 'sep';
                $configs = [
                    'terminalId' => $merchantSaman,
                ];
            }
            $invoice = (new Invoice)->amount($amount);
            $invoice->detail('mobile',auth()->user()->number);
            $property = Pay::buildCode();
            return Payment::via($gate)->config($configs)->callbackUrl(url('/order'))->purchase(
                $invoice,
                function($driver, $transactionId) use ($property,$amount,$tax,$choicePay,$getData,$request,$count) {
                    $time = Carbon::now()->format('Y-m-d h:i:s');
                    $address = auth()->user()->address()->where('show' , 1)->where('status' , 1)->first();
                    $pay = Pay::create([
                        'refId'=>'',
                        'status'=>0,
                        'tax'=>$tax,
                        'property'=>$property,
                        'price'=>$amount,
                        'gate'=>$choicePay,
                        'user_id'=>auth()->user()->id,
                        'method' => 0,
                        'auth' => (string) $transactionId,
                        'carrier_price'=> $getData[1],
                    ]);
                    $pay->address()->attach($address->id);
                    for ( $i = 0; $i < count($count); $i++) {
                        $amountP = $count[$i]->price - $count[$i]->carrier_price;
                        $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('count' , '>=' , 1)->first();
                        if($discount){
                            if($discount['day']){
                                $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                            }
                            $discountId = $discount->percent;
                            $discount->update([
                                'count'=> --$discount->count
                            ]);
                            $getPrice = ($amountP - (($amountP * $discount->percent) / 100)) * $count[$i]->count;
                        }
                        else{
                            $discountId = null;
                            $getPrice = $amountP * $count[$i]->count;
                        }
                        $guarantee = Guarantee::where('id' , $count[$i]->guarantee_id)->pluck('name')->first();
                        $product1 = Product::where('id',$count[$i]->product_id)->first();
                        $payMeta = PayMeta::create([
                            'product_id' => $product1->id,
                            'user_id' => $count[$i]->user_id,
                            'pay_id' => $pay->id,
                            'discount_off'=>$discountId,
                            'status'=>0,
                            'method'=>0,
                            'time'=> verta()->addDays($product1->time)->format('%d / %B / %Y'),
                            'price'=> $getPrice,
                            'color' => $count[$i]->color,
                            'count' => $count[$i]->count,
                            'size' => $count[$i]->size,
                            'carrier_price'=> $count[$i]->carrier_price,
                            'carrier_name'=> $product1->carriers()->value('name'),
                            'guarantee_name'=> $guarantee
                        ]);
                        $payMeta->address()->attach($address->id);
                    }
                    session()->put('transactionId' , (string) $transactionId);
                    session()->put('amount' , $amount);
                    auth()->user()->update([
                        'buy' => $choicePay
                    ]);
                }
            )->pay()->render();
        } else {
            return redirect('/checkout');
        }
    }
    public function shopWallet(Request $request)
    {
        $time = Carbon::now()->format('Y-m-d h:i:s');
        $choicePay = $request->gateway;
        $address = auth()->user()->address()->where('status' , 1)->first();
        if(!$address){
            return redirect()->back()->with([
                'message' => __('messages.select_address5')
            ]);
        }
        $getData = $this->getCart();
        if (auth()->user()->cart()->where('number' , 0)->count() >= 1) {
            $count = Cart::where('user_id' , auth()->user()->id)->where('number' , 0)->get();

            $amount = 0;
            for ( $i = 0; $i < count($count); $i++) {
                $allSum2 = ((int)$count[$i]['price'] - (int)$count[$i]['carrier_price']) * (int)$count[$i]['count'];
                $amount += (int)$allSum2;
                if($count[$i]->discount){
                    $discount = Discount::where('code' , $count[$i]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('count' , '>=' , 1)->first();
                    if ($discount) {
                        if($discount['day']){
                            $discount = Discount::where('code' , $count[$i]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                        }
                        $discount->update([
                            'count'=> $discount->count - 1
                        ]);
                        if($count[$i]['product_id'] == $discount['product_id']){
                            $amount = $amount - (($amount * $discount->percent) / 100);
                        }
                    }
                }
            }

            if($count[0]->discount){
                $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , null)->where('status' , 1)->where('count' , '>=' , 1)->first();
                if($discount){
                    if($discount['day']){
                        $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , null)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                    }
                    $discount->update([
                        'count'=> $discount->count - 1
                    ]);
                    $amount = $amount - ($amount * $discount->percent) / 100;
                }
            }

            $tax = Setting::where('key' , 'tax')->pluck('value')->first() ?? 0;
            $amount = $amount + (($amount * $tax) / 100);

            $amount += $getData[1];

            if(auth()->user()->myCharge() >= $amount){
                $property = Pay::buildCode();
                $time = Carbon::now()->format('Y-m-d h:i:s');
                $address = auth()->user()->address()->where('status' , 1)->first();
                $pay = Pay::create([
                    'refId'=>'',
                    'status'=>100,
                    'tax'=> $tax,
                    'property'=>$property,
                    'price'=>$amount,
                    'gate'=>$choicePay,
                    'user_id'=>auth()->user()->id,
                    'method' => 1,
                    'auth' => $property,
                    'carrier_price'=> $getData[1],
                ]);
                Wallet::create([
                    'refId'=>'کیف پول',
                    'status'=> 100,
                    'type' => 1,
                    'property'=>$property,
                    'price'=>$amount,
                    'user_id'=>auth()->user()->id,
                ]);
                $pay->address()->attach($address->id);
                for ( $i = 0; $i < count($count); $i++) {
                    $amountP = $count[$i]->price - $count[$i]->carrier_price;
                    $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('count' , '>=' , 1)->first();
                    if($discount){
                        if($discount['day']){
                            $discount = Discount::where('code' , $count[0]->discount)->where('product_id' , $count[$i]->product_id)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
                        }
                        $discountId = $discount->percent;
                        $discount->update([
                            'count'=> --$discount->count
                        ]);
                        $getPrice = ($amountP - (($amountP * $discount->percent) / 100)) * $count[$i]->count;
                    }
                    else{
                        $discountId = null;
                        $getPrice = $amountP * $count[$i]->count;
                    }
                    $guarantee = Guarantee::where('id' , $count[$i]->guarantee_id)->pluck('name')->first();
                    $product1 = Product::where('id',$count[$i]->product_id)->first();
                    $payMeta = PayMeta::create([
                        'product_id' => $product1->id,
                        'user_id' => $count[$i]->user_id,
                        'pay_id' => $pay->id,
                        'discount_off'=>$discountId,
                        'status'=>100,
                        'method'=>1,
                        'time'=> verta()->addDays($product1->time)->format('%d / %B / %Y'),
                        'price'=> $getPrice,
                        'color' => $count[$i]->color,
                        'count' => $count[$i]->count,
                        'size' => $count[$i]->size,
                        'carrier_price'=> $count[$i]->carrier_price,
                        'carrier_name'=> $product1->carriers()->value('name'),
                        'guarantee_name'=> $guarantee
                    ]);
                    $payMeta->address()->attach($address->id);
                    $product1->update([
                        'count' => $product1->count - $count[$i]->count
                    ]);
                    if ($count[$i]['color']){
                        $cartColor = $count[$i]['color'];
                        $colors = [];
                        foreach (json_decode($product1['colors'] , true) as $item) {
                            if($item['name'] == $cartColor){
                                $item['count'] = (int)$item['count'] - (int)$count[$i]['count'];
                            }
                            array_push($colors , $item);
                        }
                        $product1->update([
                            'colors' => json_encode($colors),
                        ]);
                    }
                    if ($count[$i]['size']){
                        $cartSize = $count[$i]['size'];
                        $sizes = [];
                        foreach (json_decode($product1['size'] , true) as $item) {
                            if($item['name'] == $cartSize){
                                $item['count'] = (int)$item['count'] - (int)$count[$i]['count'];
                            }
                            array_push($sizes , $item);
                        }
                        $product1->update([
                            'size' => json_encode($sizes),
                        ]);
                    }
                    $catPercent = $product1->category()->latest()->value('percent') ?? 0;
                    $allP = $count[$i]->price + $count[$i]->carrier_price;
                    $coap = $allP - (($allP * $catPercent) / 100);
                    $property = Checkout::buildCode();
                    $checkoutCharge = Setting::where('key' , 'checkoutCharge')->pluck('value')->first();
                    Checkout::create([
                        'user_ip' => request()->ip(),
                        'user_id' => $product1->user_id,
                        'price' => (int)$coap,
                        'type' => 1,
                        'status' => 0,
                        'pay_id' => $pay->id,
                        'charge' => Carbon::now()->addDays($checkoutCharge + $product1->time + 1),
                        'property' => $property,
                    ]);
                    $count[$i]->delete();
                }
                $this->notificationBuy($pay);
                $name = auth()->user()->name;
                return view('home.cart.buy' , compact('pay' , 'name'));
            }
            return redirect('/checkout')->with([
                'message' => __('messages.fail_buy')
            ]);
        } else {
            return redirect('/checkout')->with([
                'message' => __('messages.fail_buy')
            ]);
        }
    }
    public function order(Request $request)
    {
        $transaction_id = session()->get('transactionId');
        $transaction_amount = session()->get('amount');
        $choicePay = auth()->user()->buy;
        $pay = Pay::where('auth' , $transaction_id)->where('user_id' , auth()->user()->id)->first();

        try {
            if($choicePay == 0){
                $merchantId = Setting::where('key' , 'zarinpal')->pluck('value')->first();
                $gate = 'zarinpal';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 1){
                $merchantId = Setting::where('key' , 'zibal')->pluck('value')->first();
                $gate = 'zibal';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 2){
                $merchantId = Setting::where('key' , 'nextPay')->pluck('value')->first();
                $gate = 'nextpay';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 3){
                $merchantId = Setting::where('key' , 'idpay')->pluck('value')->first();
                $gate = 'idpay';
                $configs = [
                    'merchantId' => $merchantId,
                ];
            }
            if($choicePay == 4){
                $terminalBeh = Setting::where('key' , 'terminalBeh')->pluck('value')->first();
                $userBeh = Setting::where('key' , 'userBeh')->pluck('value')->first();
                $passwordBeh = Setting::where('key' , 'passwordBeh')->pluck('value')->first();
                $gate = 'behpardakht';
                $configs = [
                    'terminalId' => $terminalBeh,
                    'username' => $userBeh,
                    'password' => $passwordBeh,
                ];
            }
            if($choicePay == 5){
                $keySadad = Setting::where('key' , 'keySadad')->pluck('value')->first();
                $merchantSadad = Setting::where('key' , 'merchantSadad')->pluck('value')->first();
                $terminalSadad = Setting::where('key' , 'terminalSadad')->pluck('value')->first();
                $gate = 'sadad';
                $configs = [
                    'key' => $keySadad,
                    'merchantId' => $merchantSadad,
                    'terminalId' => $terminalSadad,
                ];
            }
            if($choicePay == 6){
                $terminalAsan = Setting::where('key' , 'terminalAsan')->pluck('value')->first();
                $userAsan = Setting::where('key' , 'userAsan')->pluck('value')->first();
                $passwordAsan = Setting::where('key' , 'passwordAsan')->pluck('value')->first();
                $gate = 'asanpardakht';
                $configs = [
                    'username' => $userAsan,
                    'password' => $passwordAsan,
                    'merchantConfigID' => $terminalAsan,
                ];
            }
            if($choicePay == 7){
                $merchantPasargad = Setting::where('key' , 'merchantPasargad')->pluck('value')->first();
                $terminalPasargad = Setting::where('key' , 'terminalPasargad')->pluck('value')->first();
                $certificatePasargad = Setting::where('key' , 'certificatePasargad')->pluck('value')->first();
                $gate = 'pasargad';
                $configs = [
                    'merchantId' => $merchantPasargad,
                    'terminalCode' => $terminalPasargad,
                    'certificate' => $certificatePasargad,
                ];
            }
            if($choicePay == 8){
                $merchantSaman = Setting::where('key' , 'samansep')->pluck('value')->first();
                $gate = 'sep';
                $configs = [
                    'terminalId' => $merchantSaman,
                ];
            }
            $receipt = Payment::via($gate)->config($configs)->amount($transaction_amount)->transactionId($transaction_id)->verify();
            $pay->update([
                'status' => 100,
                'refId' => $receipt->getReferenceId(),
            ]);
            foreach ($pay->payMeta as $val){
                $val->update([
                    'status' => 100,
                ]);
                $post = Product::where('id', $val->product_id)->first();
                $post->update([
                    'count' => $post->count - $val['count']
                ]);
                if ($val['color']){
                    $cartColor = $val['color'];
                    $colors = [];
                    foreach (json_decode($post['colors'] , true) as $item) {
                        if($item['name'] == $cartColor){
                            $item['count'] = (int)$item['count'] - (int)$val['count'];
                        }
                        array_push($colors , $item);
                    }
                    $post->update([
                        'colors' => json_encode($colors),
                    ]);
                }
                if ($val['size']){
                    $cartSize = $val['size'];
                    $sizes = [];
                    foreach (json_decode($post['size'] , true) as $item) {
                        if($item['name'] == $cartSize){
                            $item['count'] = (int)$item['count'] - (int)$val['count'];
                        }
                        array_push($sizes , $item);
                    }
                    $post->update([
                        'size' => json_encode($sizes),
                    ]);
                }
                $catPercent = $post->category()->latest()->value('percent') ?? 0;
                $allP = $val->price + $val->carrier_price;
                $coap = $allP - (($allP * $catPercent) / 100);
                $property = Checkout::buildCode();
                $checkoutCharge = Setting::where('key' , 'checkoutCharge')->pluck('value')->first();
                Checkout::create([
                    'user_ip' => request()->ip(),
                    'user_id' => $post->user_id,
                    'price' => (int)$coap,
                    'type' => 1,
                    'status' => 0,
                    'pay_id' => $val->id,
                    'charge' => Carbon::now()->addDays($checkoutCharge + $post->time + 1),
                    'property' => $property,
                ]);
            }
            $this->notificationBuy($pay);
            $name = auth()->user()->name;
            foreach (auth()->user()->cart()->where('number',0)->get() as $ss){
                $ss->delete();
            }
            return view('home.cart.buy' , compact('pay' , 'name'));
        }
        catch (InvalidPaymentException $exception) {
            return redirect('/checkout')->with([
                'message' => __('messages.fail_buy')
            ]);
        }
    }
    public function getCart(){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $myCart = Cart::where('number',0)->where('user_id', $user_id)->get();
        $carts = [];
        $carrierPrices = 0;
        $prices = 0;
        foreach($myCart as $item) {
            $send = Product::where('id', $item['product_id'])->with('user')->first();
            if(!$send){
                $item->delete();
            }else{
                $carrierPrice = $this->getCarrier($send);
                $getPrices = $this->getPrices($send,$item->size,$item->color);
                if(is_int($getPrices)){
                    $item->update([
                        'carrier_price' => $carrierPrice,
                        'price' => $carrierPrice + $getPrices,
                    ]);
                    $carrierPrices += $carrierPrice;
                    $prices += ($getPrices * $item->count) + $carrierPrice;
                    $data = [
                        'title' => $send->title,
                        'image' => $send->image !='[]'?json_decode($send->image)[0]:'',
                        'slug' => $send->slug,
                        'time' => $send->time,
                        'max' => $send->count,
                        'user_name' => $send->user->name,
                        'user_slug' => $send->user->slug,
                        'carrier_price' => $carrierPrice,
                        'id' => $item['id'],
                        'count' => $item['count'],
                        'size' => $item['size'],
                        'color' => $item['color'],
                        'price' => $carrierPrice + $getPrices,
                        'guarantee_id' => $item['guarantee_id'],
                    ];
                    array_push($carts, $data);
                }else{
                    $item->delete();
                }
            }
        };
        return [$carts,$carrierPrices,$prices];
    }
    public function getCarrier($product)
    {
        $weights = $product->weight/1000;
        $car = $product->carriers()->first();
        $allCP = 0;
        foreach (Cart::where('user_id' , auth()->user()->id)->where('number' , 0)->get(['product_id','count','price']) as $val){
            $productM = Product::where('id',$val->product_id)->whereHas('carriers', function ($q) use ($car) {
                $q->where('id', $car->id);
            })->first();
            if($productM){
                $weights += ($productM['weight'] * $val->count)/1000;
                $allCP += (($val->price-$val->carrier_price) * $val->count);
            }
        }
        $sends1 = Carrier::where('id' , $car->id)->first();
        if($sends1){
            if($sends1['limit'] <= $allCP + (int)($weights*$sends1['weightPrice'])){
                return 0;
            }else{
                return (int)($sends1['price'] + (int)($weights*$sends1['weightPrice']));
            }
        }else{
            return 0;
        }
    }
    public function getPrices($product,$size2,$color2)
    {
        $price = $product->price;
        if($product['colors'] && $product['colors'] != '[]'){
            $colorExist = 0;
            foreach(json_decode($product['colors']) as $item){
                if($item->name == $color2){
                    $colorExist = 1;
                    $price = (int)$price + (int)$item->price;
                    if($item->count <= 0){
                        return 'limit';
                    }
                }
            }
            if(!$colorExist){
                return 'no';
            }
        }
        if($product['size'] && $product['size'] != '[]'){
            $sizeExist = 0;
            foreach(json_decode($product['size']) as $item){
                if($item->name == $size2){
                    $sizeExist = 1;
                    $price = (int)$price + (int)$item->price;
                    if($item->count <= 0){
                        return 'limit';
                    }
                }
            }
            if(!$sizeExist){
                return 'no';
            }
        }
        return (int)$price;
    }
    public function notificationBuy($pay){
        $messageSuccess = Setting::where('key' , 'messageSuccess')->pluck('value')->first();
        $messageManager = Setting::where('key' , 'messageManager')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $link = url("show-pay/$pay->property");
        $nameFast = auth()->user() ? auth()->user()->name : $pay->address()->latest()->pluck('name')->first();
        if($messageSuccess && auth()->user()->number){
            $this->sendSms(auth()->user()->number , [auth()->user()->name , $pay->property],'',$messageSuccess);
        }
        try {
            if(auth()->user()->email){
                $text2 = "<strong>".__('messages.email1')." </strong><br/> <a href='$link'>".__('messages.track_pay')."</a>";
                SendEmailJob::dispatch($text2 , __('messages.success_buy1') , auth()->user()->email);
            }
        }catch (Exception $exception){}
        if($messageManager && $number){
            $this->sendSms($number , [$nameFast??' ' , $pay->property , $pay->price],'',$messageManager);
        }
    }
}
