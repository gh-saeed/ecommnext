<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Auto;
use App\Models\Brand;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Field;
use App\Models\FieldData;
use App\Models\Gallery;
use App\Models\Guarantee;
use App\Models\PriceChange;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Tank;
use App\Models\Time;
use App\Models\User;
use App\Models\Video;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use DonatelloZa\RakePlus\RakePlus;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use PHPHtmlParser\Dom;
use Spatie\Permission\Models\Role;

class PostController extends Controller
{
    use SendSmsTrait;
    protected static function requestTranslation($source, $target, $text) {
        $url = "https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
        $fields = array(
            'sl' => urlencode($source),
            'tl' => urlencode($target),
            'q' => urlencode($text)
        );

        $fields_string = "";
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }

        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }
    protected static function getSentencesFromJSON($json) {
        $sentencesArray = json_decode($json, true);
        $sentences = "";
        if(!empty($sentencesArray["sentences"])){
            foreach ($sentencesArray["sentences"] as $s) {
                if(!empty($s["trans"])){
                    $sentences .= $s["trans"];
                }
            }
        }
        return $sentences;
    }
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->select(['id' , 'title','slug' ,'price' ,'product_id' , 'user_id', 'image' , 'slug' , 'count','created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $products = Product::select(['id' , 'product_id' , 'title','slug' , 'user_id' ,'price' , 'slug' , 'image' , 'count','created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.post.index',compact('products','title'));
    }
    public function change(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->select(['id','title','slug','count','offPrice','off','score','weight','status','showcase','original','inquiry','prepare','time','body'])->latest()->paginate(100)->setPath($currentUrl);
        }else{
            $products = Product::select(['id','title','slug','count','offPrice','off','score','weight','status','showcase','original','inquiry','prepare','time','body'])->latest()->paginate(100)->setPath($currentUrl);
        }
        return view('admin.post.change',compact('products','title'));
    }
    public function changeData(Request $request){
        foreach(json_decode($request->products) as $item){
            if ($item->off){
                $price = round((int)$item->offPrice - ((int)$item->offPrice * $item->off / 100));
            }else{
                $price = (int)$item->offPrice;
            }
            Product::where('id' , $item->id)->first()->update([
                'title' => $item->title,
                'slug' => $item->slug,
                'count' => $item->count,
                'offPrice' => $item->offPrice,
                'priceCurrency' => $item->offPrice,
                'off' => $item->off != '' ? $item->off : null,
                'score' => $item->score != '' ? $item->score : null,
                'weight' => $item->weight != '' ? $item->weight : 10,
                'status' => $item->status,
                'showcase' => $item->showcase? 1 : 0,
                'original' => $item->original? 1 : 0,
                'inquiry' => $item->inquiry? 1 : 0,
                'body' => $item->body,
                'prepare' => $item->prepare,
                'time' => $item->time,
                'price' => $price,
            ]);
        }
        return 'success';
    }
    public function getData(Request $request){
        if($request->type == 1){
            $ch = curl_init('https://api.digikala.com/v2/product/'.$request->digikala.'/');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch,CURLOPT_TIMEOUT,10000);
            curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');
            $result = curl_exec($ch);
            $result = json_decode($result, true, JSON_PRETTY_PRINT);
            curl_close($ch);

            $images = [];
            $categories = [];
            $brands = [];
            if($result['data']['product']['images']['main']){
                $year = Carbon::now()->year;
                $time = time();
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                $url = '/upload/image/' . $year . '/';
                $img = Image::make($result['data']['product']['images']['main']['url'][0])->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                $sizefile = $img->filesize() / 1000;
                if ($sizefile > 1000) {
                    $size = round($sizefile / 1000, 2) . 'mb';
                } else {
                    $size = round($sizefile) . 'kb';
                }
                $image = Gallery::create([
                    'name' => $time . '.' . 'jpg',
                    'size' => $size,
                    'type' => 'jpg',
                    'user_id' => auth()->user()->id,
                    'url' => $url . $time . '.' . 'jpg',
                    'path' => $path . $time . '.' . 'jpg',
                ]);
                array_push($images , $image['url']);
            }
            if(!empty($result['data']['product']['images']['list'])){
                foreach($result['data']['product']['images']['list'] as $item){
                    if($result['data']['product']['images']['main']['url'][0] != $item['url'][0]){
                        $year = Carbon::now()->year;
                        $time = time();
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                        $url = '/upload/image/' . $year . '/';
                        $img = Image::make($item['url'][0])->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                        $sizefile = $img->filesize() / 1000;
                        if ($sizefile > 1000) {
                            $size = round($sizefile / 1000, 2) . 'mb';
                        } else {
                            $size = round($sizefile) . 'kb';
                        }
                        $image = Gallery::create([
                            'name' => $time . '.' . 'jpg',
                            'size' => $size,
                            'type' => 'jpg',
                            'user_id' => auth()->user()->id,
                            'url' => $url . $time . '.' . 'jpg',
                            'path' => $path . $time . '.' . 'jpg',
                        ]);
                        array_push($images , $image['url']);
                        sleep(1);
                    }
                }
            }

            if($result['data']['product']['brand']){
                $brand1 = Brand::where('name' , $result['data']['product']['brand']['title_fa'])->first();
                if($brand1){
                    $brand = $brand1;
                }else{
                    $year = Carbon::now()->year;
                    $time = time();
                    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                    $url = '/upload/image/' . $year . '/';
                    $img = Image::make($result['data']['product']['brand']['logo']['url'][0])->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                    $sizefile = $img->filesize() / 1000;
                    if ($sizefile > 1000) {
                        $size = round($sizefile / 1000, 2) . 'mb';
                    } else {
                        $size = round($sizefile) . 'kb';
                    }
                    $imagePost = Gallery::create([
                        'name' => $time . '.' . 'jpg',
                        'size' => $size,
                        'type' => 'jpg',
                        'user_id' => auth()->user()->id,
                        'url' => $url . $time . '.' . 'jpg',
                        'path' => $path . $time . '.' . 'jpg',
                    ]);
                    $brand = Brand::create([
                        'name' => $result['data']['product']['brand']['title_fa'],
                        'nameSeo' => $result['data']['product']['brand']['title_fa'],
                        'image' => $imagePost['url'],
                        'keyword' => $result['data']['product']['brand']['title_fa'],
                    ]);
                }
                array_push($brands , $brand);
            }
            if($result['data']['product']['category']){
                $category1 = Category::where('name' , $result['data']['product']['category']['title_fa'])->first();
                if($category1){
                    $category = $category1;
                }else{
                    $category = Category::create([
                        'name' => $result['data']['product']['category']['title_fa'],
                        'nameSeo' => $result['data']['product']['category']['title_fa'],
                        'keyword' => $result['data']['product']['category']['title_fa'],
                    ]);
                }
                array_push($categories , $category);
            }
            if($result['data']['product']['default_variant']){
                $price = substr($result['data']['product']['default_variant']['price']['selling_price'], 0, -1);
            }else{
                $price = 0;
            }
            return [$result['data'],$brands,$categories,$price,$images];
        }
        elseif($request->type ==0){
            $url = $request->digikala;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]);
            $htmlContent = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $gg = response($htmlContent);
            $dom = new Dom;
            $dom = $dom->loadStr($gg);
            $title = $dom->find('h1');
            if(count($title) >= 1){
                $title = $title->text;
            }else{
                $title = '';
            }

            $abilities = [];
            $ability = $dom->find('.key_specs');
            if($ability != ''){
                $ability = $ability->find('.key-specs-container');
                foreach($ability as $item){
                    $ability1 = $item->find('.keys-values' , 0);
                    if($ability1->find('span') != ''){
                        $ability1 = $ability1->find('span');
                    }
                    $ability2 = $item->find('.keys-values' , 1);
                    if($ability2->find('span') != ''){
                        $ability2 = $ability2->find('span');
                    }
                    $texts = $ability1->text . ' : ' . $ability2->text;
                    array_push($abilities , $texts);
                }
            }

            $categories = [];
            $category = '';
            $category1 = $dom->find('.breadcrumbs');
            $category1 = $category1->find('.bread-item');
            foreach($category1 as $item){
                $category = $item->find('.bread-item')->text;
            }
            if($category){
                $category1 = Category::where('name' , $category)->first();
                if($category1){
                    $category = $category1;
                }else{
                    $category = Category::create([
                        'name' => $category,
                        'nameSeo' => $category,
                        'keyword' => $category,
                    ]);
                }
                array_push($categories , $category);
            }

            $properties = [];
            $property = $dom->find('.sub-section');
            if($property != ''){
                $property = $property->find('div');
                foreach($property as $item){
                    $property1 = $item->find('.detail-title');
                    $property2 = $item->find('.detail-value');
                    if($property1 != '' && $property2 != ''){
                        $p1 = [
                            'title'=> $property1->text,
                            'body'=> $property2->text,
                        ];
                        array_push($properties , $p1);
                    }
                }
            }

            $price = 0;
            $count = 100;
            $priceElement = $dom->find('.cheapest-seller .buy_box_text', 1);
            if ($priceElement) {
                $price = $priceElement->text;
                $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                $englishNumbers = range(0, 9);
                $price = str_replace($persianNumbers, $englishNumbers, $price);
                $price = str_replace(' تومان', '', $price);
                $price = str_replace('٫', '', $price);
                if($price == 'ناموجود'){
                    $count = 0;
                }
            }

            $images = [];
            $image = $dom->find('.gallery img');
            if($image){
                $image = $image->getAttribute('src');
                $image = str_replace('280x280' , '560x560',$image);
                $year = Carbon::now()->year;
                $time = time();
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                $url = '/upload/image/' . $year . '/';
                $img = Image::make($image)->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                $sizefile = $img->filesize() / 1000;
                if ($sizefile > 1000) {
                    $size = round($sizefile / 1000, 2) . 'mb';
                } else {
                    $size = round($sizefile) . 'kb';
                }
                $image = Gallery::create([
                    'name' => $time . '.' . 'jpg',
                    'size' => $size,
                    'type' => 'jpg',
                    'user_id' => auth()->user()->id,
                    'url' => $url . $time . '.' . 'jpg',
                    'path' => $path . $time . '.' . 'jpg',
                ]);
                array_push($images , $image['url']);
            }

            return [$title,$price,$abilities,$properties,$categories,$images,$count];
        }
        else{
            $url = $request->digikala;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]);
            $htmlContent = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $gg = response($htmlContent);
            $dom = new Dom;
            $dom = $dom->loadStr($gg);
            $title = $dom->find('#productTitle');
            $title = explode('>', $title);
            if(count($title) >= 1){
                $title = explode('<', $title[1]);
                $titleEn = $title[0];
                $title = self::requestTranslation('en', 'fa', $title[0]);
                $title = self::getSentencesFromJSON($title);
            }else{
                $title = '';
                $titleEn = '';
            }

            $price1 = $dom->find('.apexPriceToPay');
            if($price1 != ''){
                $price = $price1->find('span');
                $price = explode('<', $price);
                $price = explode('>', $price[1]);
                $price = str_replace('$', '', $price[1]);
                $price = explode('.', $price);
                $price = $price[0];
            }
            else{
                $price = 0;
            }

            $brand = $dom->find('.a-spacing-small.po-brand');
            $brands = [];
            if($brand != ''){
                $brand = $brand->find('span' , 1);
                $brand = explode('<', $brand);
                $brand = explode('>', $brand[1]);
                $brand = str_replace('"', '', $brand[1]);
                $brand1 = Brand::where('name' , $brand)->first();
                if($brand1){
                    $brand = $brand1;
                }else{
                    $brand = Brand::create([
                        'name' =>$brand,
                        'nameSeo' =>$brand,
                        'image' => '',
                        'keyword' =>$brand,
                    ]);
                }
                array_push($brands , $brand);
            }

            $images = [];
            foreach($dom->find('#altImages ul li') as $item){
                $imageP1 = $item->find('img');
                $imageP1 = explode('src=', $imageP1);
                if(!empty($imageP1[1])){
                    $imageP1 = explode('"', $imageP1[1]);
                    $imageP2 = explode('._', $imageP1[1]);
                    if(count(explode('jpg', $imageP1[1])) >= 2){
                        $type = '.jpg';
                        $imageP1 = $imageP2[0].$type;
                        $year = Carbon::now()->year;
                        $time = time();
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                        $url = '/upload/image/' . $year . '/';
                        $img = Image::make($imageP1)->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                        $sizefile = $img->filesize() / 1000;
                        if ($sizefile > 1000) {
                            $size = round($sizefile / 1000, 2) . 'mb';
                        } else {
                            $size = round($sizefile) . 'kb';
                        }
                        $image = Gallery::create([
                            'name' => $time . '.' . 'jpg',
                            'size' => $size,
                            'type' => 'jpg',
                            'user_id' => auth()->user()->id,
                            'url' => $url . $time . '.' . 'jpg',
                            'path' => $path . $time . '.' . 'jpg',
                        ]);
                        array_push($images , $image['url']);
                        sleep(1);
                    }elseif(count(explode('png', $imageP1[1])) >= 2){
                        $type = '.png';
                        $imageP1 = $imageP2[0].$type;
                        $year = Carbon::now()->year;
                        $time = time();
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                        $url = '/upload/image/' . $year . '/';
                        $img = Image::make($imageP1)->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                        $sizefile = $img->filesize() / 1000;
                        if ($sizefile > 1000) {
                            $size = round($sizefile / 1000, 2) . 'mb';
                        } else {
                            $size = round($sizefile) . 'kb';
                        }
                        $image = Gallery::create([
                            'name' => $time . '.' . 'jpg',
                            'size' => $size,
                            'type' => 'jpg',
                            'user_id' => auth()->user()->id,
                            'url' => $url . $time . '.' . 'jpg',
                            'path' => $path . $time . '.' . 'jpg',
                        ]);
                        array_push($images , $image['url']);
                        sleep(1);
                    }
                }
            }

            $abilities = [];
            foreach($dom->find('#feature-bullets ul li') as $item){
                $ability = $item->find('span');
                $ability = explode('<', $ability);
                $ability = explode('>', $ability[1]);
                $ability = str_replace('"', '', $ability[1]);
                $ability = self::requestTranslation('en', 'fa', $ability);
                $ability = self::getSentencesFromJSON($ability);
                if($ability){
                    array_push($abilities , $ability);
                }
            }

            $properties = [];
            if($dom->find('#productDetails_detailBullets_sections1 tr') != ''){
                foreach($dom->find('#productDetails_detailBullets_sections1 tr') as $item){
                    $p1 = [
                        'title'=> '',
                        'body'=> '',
                    ];
                    $property1 = $item->find('.prodDetSectionEntry');
                    $property1 = explode('<', $property1);
                    $property1 = explode('>', $property1[1]);
                    $property1 = str_replace('"', '', $property1[1]);
                    $property1 = self::requestTranslation('en', 'fa', $property1);
                    $p1['title'] = self::getSentencesFromJSON($property1);

                    $property2 = $item->find('.prodDetAttrValue');
                    $property2 = explode('<', $property2);
                    if(!empty($property2[1])){
                        $property2 = explode('>', $property2[1]);
                        $property2 = str_replace('"', '', $property2[1]);
                        $property2 = self::requestTranslation('en', 'fa', $property2);
                        $p1['body'] = self::getSentencesFromJSON($property2);
                        array_push($properties , $p1);
                    }
                }
            }
            else{
                foreach($dom->find('#detailBullets_feature_div ul li') as $item){
                    $p1 = [
                        'title'=> '',
                        'body'=> '',
                    ];
                    $property1 = $item->find('.a-list-item');
                    $property1 = $property1->find('span');
                    $property1 = explode('<', $property1);
                    if(!empty($property1[1])){
                        $property1 = explode('>', $property1[1]);
                        $property1 = str_replace('"', '', $property1[1]);
                        $property1 = self::requestTranslation('en', 'fa', $property1);
                        $p1['title'] = self::getSentencesFromJSON($property1);

                        $property2 = $item->find('.a-list-item');
                        $property2 = $property2->find('span',1);
                        $property2 = explode('<', $property2);
                        if(!empty($property2[1])){
                            $property2 = explode('>', $property2[1]);
                            $property2 = str_replace('"', '', $property2[1]);
                            $property2 = self::requestTranslation('en', 'fa', $property2);
                            $p1['body'] = self::getSentencesFromJSON($property2);
                            array_push($properties , $p1);
                        }
                    }
                }
            }

            $description = $dom->find('#productDescription_feature_div #productDescription');
            $descriptions = '';
            if($description != ''){
                foreach($description->find('span') as $item) {
                    $description = explode('<', $item);
                    $description = explode('>', $description[1]);
                    $description = str_replace('"', '', $description[1]);
                    $description = self::requestTranslation('en', 'fa', $description);
                    $description = self::getSentencesFromJSON($description);
                    $descriptions = $descriptions . ' ' . $description;
                }
            }

            return [$title,$brands,$images,$abilities,$properties,$descriptions,$price,$titleEn];
        }
    }
    public function create(){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $carriers = Carrier::latest()->get(['id' , 'name','price']);
        $users = User::latest()->get(['id' , 'name']);
        $posts = '';
        return view('admin.post.create',compact('cats','posts','users','carriers','tags','brands','guarantees'));
    }
    public function edit(Product $product){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $carriers = Carrier::latest()->get(['id' , 'name','price']);
        $users = User::latest()->get(['id' , 'name']);
        $posts = Product::where('id' , $product->id)->with('category','tag','guarantee','brand','video','carriers')->first();
        return view('admin.post.edit',compact('cats','tags','carriers','users','brands','guarantees','posts'));
    }
    public function copy(Product $product){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $carriers = Carrier::latest()->get(['id' , 'name','price']);
        $posts = Product::where('id' , $product->id)->with('category','tag','guarantee','brand','video')->first();
        return view('admin.post.create',compact('cats','tags','carriers','brands','guarantees','posts'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'status' => 'required',
            'count' => 'required|integer|digits_between: 1,5',
            'price' => 'required|digits_between: 1,11',
        ]);
        if ($request->off){
            $price = round((int)$request->price - ((int)$request->price * $request->off / 100));
        }else{
            $price = (int)$request->price;
        }
        $showcase = $request->showcase == 'true' ? 1 : 0;
        $used = $request->used == 'true' ? 1 : 0;
        $inquiry = $request->inquiry == 'true' ? 1 : 0;
        $original = $request->original == 'true' ? 1 : 0;
        $productIds = Product::buildCode();
        $post = Product::create([
            'count' => $request->count,
            'title' => $request->title,
            'showcase' => $showcase,
            'used' => $used,
            'inquiry' => $inquiry,
            'weight' => $request->weight,
            'prepare' => $request->prepare,
            'time' => $request->time,
            'original' => $original,
            'status' => $request->status,
            'slug' => $request->slug,
            'image' => $request->image,
            'price' => $price,
            'offPrice' => $request->price,
            'off' => $request->off,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id ?? $productIds,
            'body' => $request->body,
            'ability' => $request->abilities,
            'size' => $request->sizes,
            'colors' => $request->colors,
        ]);
        foreach (json_decode($request->videos) as $item){
            Video::create([
                'videoable_type' => 'App\\Models\\Product',
                'videoable_id' => $post->id,
                'url' => $item->url,
            ]);
        }
        PriceChange::create([
            'price' => $price,
            'product_id' => $post->id,
        ]);
        $post->category()->sync(json_decode($request->cats));
        $post->brand()->sync(json_decode($request->brands));
        $post->guarantee()->sync(json_decode($request->guarantees));
        $post->tag()->sync(json_decode($request->tags));
        $post->carriers()->sync(json_decode($request->carriers));
    }
    public function groupAdd(Request $request){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $carriers = Carrier::latest()->get(['id' , 'name','price']);
        $users = User::latest()->get(['id' , 'name']);
        return view('admin.post.groupAdd',compact('cats','brands','users','carriers'));
    }
    public function groupAddStore(Request $request){
        $i = 0;
        foreach ($request->title as $item){
            $image = '';
            if($request->file[$i]){
                $year = Carbon::now()->year;
                $folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year;
                if (!file_exists($folder)){
                    mkdir($folder , 0755 , true);
                }
                $file = $request->file('file')[$i];
                $type = $file->getClientOriginalExtension();
                $name = time().'.'.$type;
                $size = $this->getSize($file->getsize());
                $optimizeImage = Setting::where('key' , 'optimizeImage')->pluck('value')->first();
                $changeImage = Setting::where('key' , 'changeImage')->pluck('value')->first();
                $watermarkImage = Setting::where('key' , 'watermarkImage')->pluck('value')->first();
                $watermarkStatus = Setting::where('key' , 'watermarkStatus')->pluck('value')->first();
                if ($type == "jpg" or $type == "JPG" or $type == "png" or $type == "PNG" or $type == "webp" or $type == "jpeg" or $type == "svg" or $type == "webp" or $type == "tif" or $type == "gif" or $type == "jfif"){
                    $url = "/upload/image/" . $year;
                    $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
                    $path = $path->getRealPath();
                    if($type != "gif"){
                        $img = Image::make($path);
//                File::delete($path);
                        $name = time().'.'.$changeImage;
                        $img->encode($changeImage , $optimizeImage);
                        if($watermarkStatus){
                            $img->insert($_SERVER['DOCUMENT_ROOT'] . $watermarkImage, 'bottom-right', 10, 10);
                        }
                        $img->save($_SERVER['DOCUMENT_ROOT'] . $url . '/' . $name , $optimizeImage);
                        $size = $this->getSize($img->filesize());
                        $path = $img->basePath();
                    }
                }
                elseif ($type == "mp3"){
                    $url = "/upload/music/" . $year;
                    $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
                    $path = $path->getRealPath();
                }
                elseif ($type == "mp4" or $type == "mkv"){
                    $url = "/upload/movie/" . $year;
                    $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
                    $path = $path->getRealPath();
                }else{
                    $url = "/upload/file/" . $year;
                    $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
                    $path = $path->getRealPath();
                }
                $image1 = Gallery::create([
                    'name' => $name,
                    'size' => $size,
                    'type' => $type,
                    'user_id' => auth()->user()->id,
                    'url' => $url . '/' . $name ,
                    'path' => $path,
                ]);
                $image = $image1['url'];
            }
            if ($request->off[$i]){
                $price = round((int)$request->price[$i] - ((int)$request->price[$i] * $request->off[$i] / 100));
            }else{
                $price = (int)$request->price[$i];
            }
            $showcase = 0;
            $used = 0;
            $inquiry = 0;
            $original = 0;
            $productIds = Product::buildCode();
            $post = Product::create([
                'count' => $request->count[$i],
                'title' => $request->title[$i],
                'showcase' => $showcase,
                'used' => $used,
                'inquiry' => $inquiry,
                'weight' => $request->weight[$i],
                'prepare' => $request->prepare[$i],
                'time' => $request->time[$i],
                'original' => $original,
                'status' => $request->status[$i],
                'slug' => $request->slug[$i],
                'image' => json_encode([$image]),
                'price' => $price,
                'offPrice' => $request->price[$i],
                'off' => $request->off[$i],
                'user_id' => $request->user_id[$i],
                'product_id' => $productIds,
                'body' => $request->body[$i],
                'ability' => json_encode([]),
                'size' => json_encode([]),
                'colors' => json_encode([]),
            ]);
            PriceChange::create([
                'price' => $price,
                'product_id' => $post->id,
            ]);
            $post->category()->sync($request->cats[$i]);
            $post->brand()->sync($request->brands[$i]);
            $post->carriers()->sync($request->carriers[$i]);
            ++$i;
        }
        return redirect('/admin/product')->with([
            'message' => 'محصولات با موفقیت اضافه شدند'
        ]);
    }
    public function update(Product $product,Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'status' => 'required',
            'count' => 'required|integer|digits_between: 1,5',
            'price' => 'required|digits_between: 1,9',
        ]);
        if ($request->off){
            $price = round((int)$request->price - ((int)$request->price * $request->off / 100));
        }else{
            $price = (int)$request->price;
        }
        $showcase = $request->showcase == 'true' ? 1 : 0;
        $used = $request->used == 'true' ? 1 : 0;
        $inquiry = $request->inquiry == 'true' ? 1 : 0;
        $original = $request->original == 'true' ? 1 : 0;

        if($product->price != $price){
            PriceChange::create([
                'price' => $price,
                'product_id' => $product->id,
            ]);
            Cart::where('product_id' , $product->id)->delete();
        }
        if($product->slug != $request->slug){
            Redirect::create([
                'start' => url('/product/'.$product->slug),
                'end' => url('/product/'.$request->slug),
                'type' => 301,
            ]);
        }
        $post = $product->update([
            'count' => $request->count,
            'title' => $request->title,
            'showcase' => $showcase,
            'used' => $used,
            'inquiry' => $inquiry,
            'weight' => $request->weight,
            'user_id' => $request->user_id,
            'prepare' => $request->prepare,
            'time' => $request->time,
            'original' => $original,
            'status' => $request->status,
            'slug' => $request->slug,
            'image' => $request->image,
            'price' => $price,
            'offPrice' => $request->price,
            'off' => $request->off,
            'body' => $request->body,
            'ability' => $request->abilities,
            'size' => $request->sizes,
            'colors' => $request->colors,
        ]);
        Video::where('videoable_type' , 'App\\Models\\Product')->where('videoable_id' , $product->id)->delete();
        foreach (json_decode($request->videos) as $item){
            Video::create([
                'videoable_type' => 'App\\Models\\Product',
                'videoable_id' => $product->id,
                'url' => $item->url,
            ]);
        }
        $product->category()->detach();
        $product->brand()->detach();
        $product->guarantee()->detach();
        $product->tag()->detach();
        $product->carriers()->detach();
        $product->category()->sync(json_decode($request->cats));
        $product->brand()->sync(json_decode($request->brands));
        $product->guarantee()->sync(json_decode($request->guarantees));
        $product->tag()->sync(json_decode($request->tags));
        $product->carriers()->sync(json_decode($request->carriers));
        return 'success';
    }
    public function show(Product $product){
        $posts = Product::where('id' , $product->id)->withCount('like','bookmark','comments')->with('category','guarantee','brand')->first();
        return view('admin.post.show',compact('posts'));
    }
    public function delete(Product $product){
        Redirect::create([
            'start' => url('/product/'.$product->slug),
            'end' => url(''),
            'type' => 410,
        ]);
        Redirect::create([
            'start' => url('/productID/'.$product->id),
            'end' => url(''),
            'type' => 410,
        ]);
        $product->category()->detach();
        $product->brand()->detach();
        $product->tag()->detach();
        $product->guarantee()->detach();
        $product->comments()->delete();
        $product->like()->delete();
        $product->bookmark()->delete();
        $product->cart()->delete();
        $product->payMeta()->delete();
        $product->delete();
        return redirect()->back()->with([
            'message' => 'محصول با موفقیت حذف شد'
        ]);
    }
    public function deleteGroup(Request $request){
        foreach (json_decode($request->products) as $item){
            $product = Product::where('id' , $item)->first();
            Redirect::create([
                'start' => url('/product/'.$product->slug),
                'end' => url(''),
                'type' => 410,
            ]);
            Redirect::create([
                'start' => url('/productID/'.$product->id),
                'end' => url(''),
                'type' => 410,
            ]);
            $product->category()->detach();
            $product->brand()->detach();
            $product->tag()->detach();
            $product->guarantee()->detach();
            $product->comments()->delete();
            $product->like()->delete();
            $product->bookmark()->delete();
            $product->cart()->delete();
            $product->payMeta()->delete();
            $product->delete();
        }
        return 'success';
    }

    public function digikala(Request $request)
    {
        $title = $request->title;
        $links = Auto::latest()->when($title != '', function ($query) use($title) {
            return $query->whereHas('user', function ($q) use ($title) {
                $q->where('name' , "LIKE" , "%{$title}%");
            });
        })->select(['link','status','page','id'])->paginate(50);
        $users = User::latest()->get(['name','id']);
        $cats = Category::latest()->get(['name','id']);
        return view('admin.post.digikala',compact('links','users','cats','title'));
    }
    public function storeDigikala(Request $request)
    {
        $request->validate([
            'link' => 'required',
            'status' => 'required',
            'user_id' => 'required',
        ]);
        Auto::create([
            'link' => $request->link,
            'status' => $request->status,
            'percent' => $request->percent,
            'prefix' => $request->prefix,
            'currency' => $request->currency,
            'digikala' => $request->digikala,
            'imageUpdate' => $request->imageUpdate,
            'user_id' => $request->user_id,
            'cat_id' => $request->cat_id,
        ]);
        return redirect()->back()->with([
            'message' => 'لینک با موفقیت اضافه شد'
        ]);
    }
    public function getDigikala(Request $request)
    {
        return Auto::where('id' , $request->link)->first();
    }
    public function updateDigikala(Auto $auto,Request $request)
    {
        $request->validate([
            'link' => 'required',
            'status' => 'required',
            'user_id' => 'required',
        ]);
        $auto->update([
            'link' => $request->link,
            'status' => $request->status,
            'percent' => $request->percent,
            'currency' => $request->currency,
            'digikala' => $request->digikala,
            'imageUpdate' => $request->imageUpdate,
            'prefix' => $request->prefix,
            'user_id' => $request->user_id,
            'cat_id' => $request->cat_id,
        ]);
        return redirect()->back()->with([
            'message' => $request->link . ' با موفقیت ویرایش شد'
        ]);
    }
    public function reset(Auto $auto)
    {
        $auto->update([
            'page' => 0,
        ]);
        return redirect()->back()->with([
            'message' => $auto->link . ' با موفقیت ویرایش شد'
        ]);
    }
    public function getSize($data){
        $sizefile = $data/1000;
        if( $sizefile > 1000){
            $size=round($sizefile/1000 ,2) . 'mb';
        }else{
            $size=round($sizefile) . 'kb';
        }
        return $size;
    }
}
