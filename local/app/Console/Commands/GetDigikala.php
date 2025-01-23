<?php

namespace App\Console\Commands;

use App\Models\Auto;
use App\Models\Carrier;
use App\Models\Category;
use App\Models\PriceChange;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class GetDigikala extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-digikala-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Setting::where('key' , 'roboStatus1')->first()->update([
            'value' => 1
        ]);
        $links = Auto::orderBy('page')->where('status',1)->where('type',0)->take(10)->get();
        foreach ($links as $item){
            try {
                $currency = $item->currency == 1 ? .1 : 1;
                $page = ++$item->page;
                $item->update([
                    'page' => $page
                ]);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.digikala.com/v1/sellers/'.$item->link.'/?page='.$page);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch,CURLOPT_TIMEOUT,10000);
                curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');
                $result = curl_exec($ch);
                $result = json_decode($result, true, JSON_PRETTY_PRINT);
                curl_close($ch);
                if($result){
                    if(count($result['data']['products']) >= 1){
                        foreach ($result['data']['products'] as $val){
                            $urlP = explode('/' , $val['url']['uri']);
                            $urlP2 = str_replace('dkp-','',$urlP);
                            $ch = curl_init('https://api.digikala.com/v2/product/'.$urlP2[2].'/');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($ch,CURLOPT_TIMEOUT,10000);
                            curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');
                            $result = curl_exec($ch);
                            $result = json_decode($result, true, JSON_PRETTY_PRINT);
                            curl_close($ch);
                            if($result){
                                $product_id = $urlP2[2];
                                $title = $result['data']['product']['title_fa'];
                                $off = 0;
                                if($result['data']['product']['default_variant']){
                                    $price = substr($result['data']['product']['default_variant']['price']['selling_price'], 0, -1);
                                    $offPrice = substr($result['data']['product']['default_variant']['price']['selling_price'], 0, -1);
                                }else{
                                    $price = 0;
                                    $offPrice = 0;
                                }
                                $price = $price - (($price * $item->percent) / 100);
                                $offPrice = $offPrice - (($offPrice * $item->percent) / 100);
                                $images = [];
                                $category = [];
                                if($result['data']['product']['category']){
                                    $category1 = Category::where('name' , $result['data']['product']['category']['title_fa'])->first();
                                    if($category1){
                                        $category2 = $category1;
                                    }else{
                                        $category2 = Category::create([
                                            'name' => $result['data']['product']['category']['title_fa'],
                                            'nameSeo' => $result['data']['product']['category']['title_fa'],
                                            'percent' => 0,
                                            'bodySeo' => $result['data']['product']['category']['title_fa'],
                                            'body' => $result['data']['product']['category']['title_fa'],
                                            'type' => 0,
                                            'image' => '',
                                            'keyword' => $result['data']['product']['category']['title_fa'],
                                        ]);
                                    }
                                    array_push($category , $category2->id);
                                }

                                if($result['data']['product']['images']['main']){
                                    array_push($images,$result['data']['product']['images']['main']['url'][0]);
                                }
                                if(!empty($result['data']['product']['images']['list'])){
                                    foreach($result['data']['product']['images']['list'] as $el2){
                                        array_push($images,$el2['url'][0]);
                                    }
                                }

                                $colors = [];
                                $abilities = [];
                                foreach ($result['data']['product']['colors'] as $el2){
                                    $color = [
                                        'name' => $el2['title'],
                                        'count' => 1,
                                        'price' => 0,
                                    ];
                                    array_push($colors,$color);
                                }
                                if(!empty($result['data']['product']['review']['attributes'])){
                                    foreach ($result['data']['product']['review']['attributes'] as $el2){
                                        $ability = [
                                            'name' => $el2['title'] . ' : ' . $el2['values'][0],
                                        ];
                                        array_push($abilities,$ability);
                                    }
                                }
                                if(!empty($result['data']['product']['specifications'][0]['attributes'])){
                                    foreach ($result['data']['product']['specifications'] as $el2){
                                        foreach ($el2['attributes'] as $el){
                                            $ability = [
                                                'name' => $el['title'] . ' : ' . $el['values'][0],
                                            ];
                                            array_push($abilities,$ability);
                                        }
                                    }
                                }
                                $pu = Product::where('user_id' , $item->user_id)->where(function ($query) use ($title,$product_id){
                                    $query->where("title", $title)
                                        ->orWhere("product_id", $product_id);
                                })->first();
                                if($pu){
                                    $pu->update([
                                        'count' => $price == 0 ? 0 : 1,
                                        'title' => $title,
                                        'off' => $off,
                                        'price' => $price * $currency,
                                        'image' => $item->imageUpdate ? json_encode($images) : $pu->image,
                                        'offPrice' => $offPrice * $currency,
                                        'ability' => json_encode($abilities),
                                        'colors' => json_encode($colors),
                                    ]);
                                    $pu->category()->sync($category);
                                    if ($pu->price != $price) {
                                        PriceChange::create([
                                            'price' => $price,
                                            'product_id' => $pu->id,
                                        ]);
                                    }
                                    $pu->carriers()->detach();
                                    $ca = Carrier::where('user_id',$item->user_id)->first();
                                    if($ca){
                                        $pu->carriers()->sync($ca->id);
                                    }else{
                                        $ca = Carrier::create([
                                            'name' => 'ارسال رایگان',
                                            'user_id' => $item->user_id,
                                            'price' => 0,
                                            'limit' => 900000,
                                            'weight' => 900000,
                                            'weightPrice' => 0,
                                        ]);
                                        $pu->carriers()->sync($ca->id);
                                    }
                                }
                                else{
                                    $user = User::where('id', $item->user_id)->first();
                                    $pp = Product::create([
                                        'title' => $title,
                                        'prepare' => 1,
                                        'time' => 1,
                                        'weight' => 100,
                                        'type' => 0,
                                        'score' => '',
                                        'status' => 0,
                                        'showcase' => 0,
                                        'used' => 0,
                                        'original' => 1,
                                        'image' => json_encode($images),
                                        'count' => $price == 0 ? 0 : 1,
                                        'off' => $off,
                                        'price' => $price * $currency,
                                        'offPrice' => $offPrice * $currency,
                                        'user_id' => $user->id,
                                        'product_id' => $product_id,
                                        'body' => $title,
                                        'ability' => json_encode($abilities),
                                        'colors' => json_encode($colors),
                                        'inquiry' => 0,
                                        'size' => json_encode([]),
                                    ]);
                                    PriceChange::create([
                                        'price' => $price,
                                        'product_id' => $pp->id,
                                    ]);
                                    $pp->category()->sync($category);
                                    $pp->carriers()->detach();
                                    $ca = Carrier::where('user_id',$item->user_id)->first();
                                    if($ca){
                                        $pp->carriers()->sync($ca->id);
                                    }else{
                                        $ca = Carrier::create([
                                            'name' => 'ارسال رایگان',
                                            'user_id' => $item->user_id,
                                            'price' => 0,
                                            'limit' => 900000,
                                            'weight' => 900000,
                                            'weightPrice' => 0,
                                        ]);
                                        $pp->carriers()->sync($ca->id);
                                    }
                                }
                            }
                        }
                    }else{
                        if($item->page == 1 || $item->page == 0){
                            $item->update([
                                'status' => 1
                            ]);
                        }else{
                            $item->update([
                                'page' => 0
                            ]);
                        }
                    }
                }
                else{
                    if($item->page == 1 || $item->page == 0){
                        $item->update([
                            'status' => 1
                        ]);
                    }else{
                        $item->update([
                            'page' => 0
                        ]);
                    }
                }
            } catch (\Exception $e) {
            }
        }
        return 'ok';
    }
    function cleanTitle($title) {
        return trim(preg_replace('/\s+/', ' ', $title));
    }
}
