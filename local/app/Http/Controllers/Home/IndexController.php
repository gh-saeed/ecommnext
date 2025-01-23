<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\TorobProduct;
use App\Models\Ask;
use App\Models\Category;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Story;
use App\Models\Subscribe;
use App\Models\User;
use App\Models\Widget;
use App\Traits\SendSmsTrait;
use App\Traits\SeoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

class IndexController extends Controller
{
    use SeoHelper;
    use SendSmsTrait;
    public function index(Request $request){
        $this->setIndexSeo();
        $cacheTime = Setting::where('key' , 'cacheTime')->pluck('value')->first();
        $cacheStatus = Setting::where('key' , 'cacheStatus')->pluck('value')->first();
        if($cacheStatus){
            $widget = Cache::remember('widgets_cache_key2', $cacheTime, function () use($request) {
                $Agent = new Agent();
                $widgetsR = Widget::where('user_id', 0)->where('status', 1)->where('responsive', 1)->count();
                $widgets = Widget::where('user_id', 0)->where('status', 1)
                    ->when($Agent->isMobile() && $widgetsR >= 1, function ($query) {
                        return $query->where('responsive', 1);
                    }, function ($query) {
                        return $query->where('responsive', 0);
                    })
                    ->orderBy('number')
                    ->get();
                return $this->getWidget($widgets,$request);
            });
        }
        else{
            $Agent = new Agent();
            $widgetsR = Widget::where('user_id', 0)->where('status', 1)->where('responsive', 1)->count();
            $widgets = Widget::where('user_id', 0)->where('status', 1)
                ->when($Agent->isMobile() && $widgetsR >= 1, function ($query) {
                    return $query->where('responsive', 1);
                }, function ($query) {
                    return $query->where('responsive', 0);
                })
                ->orderBy('number')
                ->get();
            $widget = $this->getWidget($widgets,$request);
        }

        $products = Product::where('status',1)->latest()->take(6)->get(['title','price','image','slug']);
        $stories = Story::latest()->has('user')->with('user')->take(6)->get(['title','user_id','updated_at','id','image','cover','type']);
        $categories = Category::latest()->has('product')->where('type',0)->take(6)->get();
        $bazar = $products->concat($stories)->concat($categories)->shuffle();

        $popUpStatus = Setting::where('key', 'popUpStatus')->value('value');
        $popUp = empty($_COOKIE['popUp']) && $popUpStatus == 1 ? 1 : 0;
        $imagePopUp = Setting::where('key' , 'imagePopUp')->pluck('value')->first();
        $titlePopUp = Setting::where('key' , 'titlePopUp')->pluck('value')->first();
        $addressPopUp = Setting::where('key' , 'addressPopUp')->pluck('value')->first();
        $descriptionPopUp = Setting::where('key' , 'descriptionPopUp')->pluck('value')->first();
        $buttonPopUp = Setting::where('key' , 'buttonPopUp')->pluck('value')->first();
        $moment = Product::where('status',1)->where('off','>=',1)->latest()->take(6)->get(['title','user_id','price','image','slug']);
        return view('home.index.index',compact('widget','bazar','popUp','popUpStatus','imagePopUp','titlePopUp','addressPopUp','descriptionPopUp','buttonPopUp','moment'));
    }
    public function getWidget($widgets , $request){
        $widget = [];
        foreach ($widgets as $item){
            $widgetCategory = [
                'name'=> $item['name'],
                'title'=> $item['title'],
                'more'=> $item['more'],
                'description'=> $item['description'],
                'background'=> $item['background'],
                'slug'=> $item['slug'],
                'count'=> $item['count'],
                'sort'=> $item['sort'],
                'type'=> $item['type'],
                'brands'=> $item['brands'],
                'users'=> $item['users'],
                'cats'=> $item['cats'],
                'ads1'=> $item['ads1'],
                'ads2'=> $item['ads2'],
                'ads3'=> $item['ads3'],
                'post'=> [],
            ];
            if($item['name'] == 'دسته بندی' || $item['name'] == 'دسته بندی2'){
                $widgetCategory['post'] = Category::whereIn('id' , json_decode($item['cats'],true))->get();
            }
            if($item['name'] == 'معرفی سایت'){
                $users = User::whereIn('id' , json_decode($item['users'],true))->pluck('id');
                $widgetCategory['post'] = Product::take(10)->whereIn('user_id', $users)->get();
            }
            if($item['name'] == 'لحظه ای' || $item['name'] == 'محصولات اسلایدری'){
                if($item['users'] && $item['users'] != '[]'){
                    $users = User::whereIn('id' , json_decode($item['users'],true))->pluck('id');
                    $widgetCategory['post'] = Product::take(10)->where('status',1)->whereIn('user_id', $users)->get(['title','price','image','slug','user_id']);
                }else{
                    $widgetCategory['post'] = Product::take(10)->where('status',1)->get(['title','price','image','slug','user_id']);
                }
            }
            if($item['name'] == 'بلاگ' || $item['name'] == 'بلاگ2'){
                $cats = Category::whereIn('id' , json_decode($item['cats'],true))->pluck('id');
                if(count($cats) >= 1){
                    $widgetCategory['post'] = News::latest()->take($item['count'])->whereHas('category', function ($q) use ($cats) {
                        $q->whereIn('id', $cats);
                    })->select(['title' , 'slug' , 'imageAlt' , 'bodySeo','user_id' , 'image'])->get();
                }else{
                    $widgetCategory['post'] = News::latest()->take($item['count'])->select(['title' , 'slug' , 'imageAlt' ,'user_id' , 'bodySeo' , 'image'])->get();
                }
            }
            if($item['name'] == 'استوری' || $item['name'] == 'استوری2'){
                $users = User::whereIn('id' , json_decode($item['users'],true))->pluck('id');
                $widgetCategory['post'] = Story::whereIn('user_id', $users)->get();
            }
            if($item['name'] == 'لیست غرفه'){
                $widgetCategory['post'] = User::whereIn('id' , json_decode($item['users'],true))->get();
            }
            if($item['name'] == 'تک غرفه'){
                $widgetCategory['post'] = User::whereIn('id' , json_decode($item['users'],true))->has('documentSuccess')->with("documentSuccess")->first();
            }
            array_push($widget , $widgetCategory);
        }
        return $widget;
    }
    public function faq(){
        $asks = Ask::get();
        return view('home.faq.index',compact('asks'));
    }
    public function page(Page $page){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $logo = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        $map = Setting::where('key' , 'map')->pluck('value')->first() ?:'' ;
        $this->seoSingleSeo(   $page->titleSeo . " - $title " , $page->bodySeo , 'store' , 'page/'."$page->slug" , $logo , $page->keyword);
        return view('home.page.index' , compact('page'));
    }

    public function search(Request $request){
        $searches = [];
        $searchEx = explode(' ',$request->search);
        foreach ($searchEx as $search){
            $products = Product::where(function ($query) use ($search){
                $query->where("title", "LIKE", "%".$search."%")
                    ->orWhere("product_id", "LIKE", "%".$search."%");
            })->where('status' , 1)->pluck('id');
            foreach ($products as $product){
                array_push($searches , $product);
            }
        }
        $arr = [];
        foreach(array_count_values($searches) as $key=>$item){
            if($item == count($searchEx)){
                array_push($arr , $key);
            }
        }
        return Product::whereIn('id' , $arr)->get(['id' ,'title','slug','image','price','product_id']);
    }


    public function sendSub(Request $request){
        $sub = Subscribe::where('name' , $request->email)->first();
        if(!$sub){
            Subscribe::create([
                'name' => $request->email
            ]);
            return 'ok';
        }else{
            return 'exist';
        }
    }
    public function torob(Request $request){
        $catPost1 = Product::latest()->where('status' , 1)->paginate(100);
        return TorobProduct::collection($catPost1);
    }
}
