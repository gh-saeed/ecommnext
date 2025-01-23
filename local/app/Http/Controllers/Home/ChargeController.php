<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Pay;
use App\Models\Setting;
use App\Models\Wallet;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class ChargeController extends Controller
{
    public function index(){
        $wallets = Wallet::latest()->where('user_id' , auth()->user()->id)->paginate(60);
        $walletsSuccess = Wallet::latest()->where('type' , 0)->where('user_id' , auth()->user()->id)->where('status' , 100)->pluck('price')->sum();
        $walletsFail = Wallet::latest()->where('type' , 0)->where('user_id' , auth()->user()->id)->where('status' , '!=' , 100)->pluck('price')->sum();
        $walletsIncrease = Wallet::latest()->where('type' , 1)->where('user_id' , auth()->user()->id)->where('status' , 100)->pluck('price')->sum();
        $walletsDecrease = Wallet::latest()->where('type' , 1)->where('user_id' , auth()->user()->id)->where('status' , '!=' , 100)->pluck('price')->sum();

        return view('home.profile.wallet' , compact('wallets','walletsSuccess','walletsFail','walletsIncrease','walletsDecrease'));
    }
    public function addCharge(Request $request)
    {
        $request->validate([
            'price' => 'required|integer|min:5000',
        ]);
        $choicePay = Setting::where('key' , 'choicePay')->pluck('value')->first();
        if (auth()->user()) {
            auth()->user()->update([
                'buy'=> $request->price,
            ]);
            $amount = $request->price;
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
            $invoice = (new Invoice)->amount($amount);
            $property = Pay::buildCode();
            return Payment::via($gate)->config($configs)->callbackUrl(url('/charge/order'))->purchase(
                $invoice,
                function($driver, $transactionId) use ($amount) {
                    $chars2 = Pay::buildCode();
                    $pay = Wallet::create([
                        'refId'=>$transactionId,
                        'status'=>0,
                        'property'=>$chars2,
                        'price'=>$amount,
                        'type'=>0,
                        'user_id'=>auth()->user()->id,
                    ]);
                    session()->put('transactionId' , (string) $transactionId);
                    session()->put('amount' , $amount);
                }
            )->pay()->render();
        } else {
            return redirect('/');
        }
    }

    public function chargeOrder(Request $request)
    {
        $choicePay = Setting::where('key' , 'choicePay')->pluck('value')->first();
        $transaction_id = session()->get('transactionId');
        $transaction_amount = session()->get('amount');
        $pay = Wallet::where('refId' , $transaction_id)->where('user_id' , auth()->user()->id)->first();
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
            $receipt = Payment::via($gate)->config($configs)->amount($transaction_amount)->transactionId($transaction_id)->verify();
            $pay->update([
                'status' => 100,
                'refId' => $receipt->getReferenceId(),
            ]);
            $name = auth()->user()->name;
            auth()->user()->update([
                'buy'=> null
            ]);
            return view('home.cart.buy' , compact('pay' , 'name'));
        } catch (InvalidPaymentException $exception) {
            $pay->update([
                'status' => 0,
            ]);
            $name = auth()->user()->name;
            auth()->user()->update([
                'buy'=> null
            ]);
            return view('home.cart.buy' , compact('pay' , 'name'));
        }
    }
}
