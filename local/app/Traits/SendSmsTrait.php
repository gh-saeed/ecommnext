<?php


namespace App\Traits;


use App\Models\Setting;
use Ghasedak\GhasedakApi;
use GuzzleHttp\Client;

trait SendSmsTrait
{
    public function sendSms($number,$message,$line,$theme){
        $smsType = Setting::where('key' , 'smsType')->pluck('value')->first();
        if($smsType == 0){
            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
            $api->Verify(
                "$number",
                "$theme",
                $message
            );
        }
        if($smsType == 1){
            $userSms = Setting::where('key' , 'userSms')->pluck('value')->first();
            $passSms = Setting::where('key' , 'passSms')->pluck('value')->first();
            $text = implode(';',$message);
            $url = "https://api.payamak-panel.com/post/Send.asmx/SendByBaseNumber2?username=$userSms&password=$passSms&text=$text;&to=$number&bodyId=$theme";
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
            $texts = [];
            for ( $i = 0; $i < count($message); $i++) {
                if($i == 0){
                    $check = 'token='.str_replace(' ', '', $message[$i]);
                }
                if($i == 1){
                    $check = 'token2='.str_replace(' ', '', $message[$i]);
                }
                if($i == 2){
                    $check = 'token3='.str_replace(' ', '', $message[$i]);
                }
                array_push($texts , $check);
            }
            $text = implode('&',$texts);
            $url = "https://api.kavenegar.com/v1/$kaveKey/verify/lookup.json?receptor=$number&$text&template=$theme";
            $client = new Client();
            $response = $client->request('GET', $url,
                [
                    'allow_redirects' => true
                ]);
            $contents = $response->getBody()->getContents();
            $contents = json_decode($contents,true);
        }
        if($smsType == 3){
            $input_data = [];
            if(count($message) == 1){
                $input_data = array('token' => $message[0]);
            }
            if(count($message) == 2){
                $input_data = array('token' => $message[0] , 'token2' => $message[1]);
            }
            if(count($message) == 3){
                $input_data = array('token' => $message[0] , 'token2' => $message[1] , 'token3' => $message[2]);
            }
            $user = Setting::where('key' , 'userFaraz')->pluck('value')->first();
            $pass = Setting::where('key' , 'passFaraz')->pluck('value')->first();
            $fromNum = Setting::where('key' , 'numberFaraz')->pluck('value')->first();
            $toNum = array($number);
            $pattern_code = $theme;
            $url = 'https://ippanel.com/patterns/pattern?username=' . $user . '&password=' . urlencode($pass) . '&from='.$fromNum.'&to=' . json_encode($toNum) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code='.$pattern_code;
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($input_data));
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
        }
    }
}
