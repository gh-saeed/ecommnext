<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\News;
use App\Models\PayMeta;
use App\Models\PriceChange;
use App\Models\Product;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Story;
use App\Models\User;
use App\Models\Widget;
use App\Traits\SeoHelper;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    use SeoHelper;
    public function product(Product $product){
        $carrierPrice = $this->getCarrier($product);
        $images = $product->image != '[]' ? json_decode($product->image) : [];
        $products = $product;
        $seller = $products->user;
        $sellerProducts = Product::where('user_id',$product->user_id)->latest()->where('status',1)->take(5)->get();
        $related = Product::orderByRaw('count > 0 DESC')->where('id', '!=', $product->id)
            ->where('status', 1)
            ->whereHas('category', function ($q) use ($product) {
                $q->whereIn('name', $product->category()->pluck('name'));
            })
            ->take(10)
            ->get();
        $sellerPays = PayMeta::where('status',100)->whereHas('product', function ($q) use ($seller) {
            $q->where('user_id', $seller->id);
        })->count();
        $onlineCheck = $seller->isOnline();
        $comments = Comment::where('type',0)->where('product_id',$products->id)->where('status',1)->with('user')->get();
        $productRate = Comment::where('type',0)->where('product_id',$products->id)->where('status',1)->avg('rate');
        $like = $bookmark = $levelUser = null;
        $paid = false;
        $cart = '';
        if (auth()->check()) {
            $like = Like::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        }
        $changes = PriceChange::where('product_id',$product->id)->get();
        $singleDesign = Setting::where('key' , 'singleDesign')->pluck('value')->first();
        if($singleDesign == 2){
            $view = 'home.single.product2';
        }else{
            $view = 'home.single.product';
        }
        return view($view,compact('products','images','changes','productRate','like','comments','onlineCheck','sellerPays','sellerProducts','related','seller','carrierPrice'));
    }
    public function like(Request $request){
        $user = auth()->user();
        if(!$user){
            return 'noUser';
        }
        $like = Like::where('product_id' , $request->product)->where('user_id' , $user->id)->first();
        if($like){
            $like->delete();
            return 'delete';
        }else{
            $like = Like::create([
                'user_id'=>$user->id,
                'product_id'=>$request->product,
            ]);
            return 'success';
        }
    }
    public function sendReport(Request $request){
        $user = auth()->user();
        if(!$user){
            return 'noUser';
        }
        if(Report::where('status',0)->where('user_id',auth()->id())->where('reportable_id',$request->product)->where('reportable_type','App\\Models\\Product')->first()){
            return 'no';
        }
        Report::create([
            'data' => $request->body,
            'user_id' => auth()->id(),
            'reportable_id' => $request->product,
            'reportable_type' => $request->type == 0 ? 'App\\Models\\Product' : 'App\\Models\\User',
        ]);
    }
    public function sellerVendor(Request $request,User $user){
        $widgets = Widget::where('user_id',$user->id)->where('status', 1)->orderBy('number')->get();
        $widget = $this->getWidget($widgets,$request,$user);
        $products = Product::where('user_id',$user->id)->where('status',1)->latest()->take(6)->get(['title','price','image','slug']);
        $stories = Story::where('user_id',$user->id)->latest()->has('user')->with('user')->take(6)->get(['title','user_id','updated_at','id','image','cover','type']);
        $bazar = $products->concat($stories)->shuffle();
        $moment = Product::where('user_id',$user->id)->where('status',1)->latest()->take(6)->get(['title','user_id','price','image','slug']);
        return view('home.single.seller.page', compact('widget','user','moment','bazar'));
    }
    public function getWidget($widgets , $request,$user){
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
                $widgetCategory['post'] = Product::where('user_id',$user->id)->take(10)->where('user_id', $user->id)->get();
            }
            if($item['name'] == 'لیست غرفه'){
                $widgetCategory['post'] = User::where('id' , auth()->id())->get();
            }
            if($item['name'] == 'تک غرفه'){
                $widgetCategory['post'] = User::where('id' , auth()->id())->first();
            }
            if($item['name'] == 'لحظه ای' || $item['name'] == 'محصولات اسلایدری'){
                if($item['cats'] && $item['cats'] != '[]'){
                    $cats1 = Category::whereIn('id' , json_decode($item['cats'],true))->pluck('id')->toArray();
                    $widgetCategory['post'] = Product::take(8)
                        ->whereHas('category', function ($q) use ($cats1) {
                            $q->whereIn('id', $cats1);
                        })->where('status',1)->where('user_id', $user->id)->get(['title','price','image','slug','user_id']);
                }else{
                    $widgetCategory['post'] = Product::take(8)->where('user_id', $user->id)->where('status',1)->get(['title','price','image','slug','user_id']);
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
                $widgetCategory['post'] = Story::where('user_id', $user->id)->get();
            }
            array_push($widget , $widgetCategory);
        }
        return $widget;
    }
    public function seller(Request $request,User $user){
        $product = $user->product()->where('status',1)->get();
        $maxPrice = $product->max('price');
        $minPrice = $product->min('price');

        $color = $product->flatMap(function ($item) {
            $colors = json_decode($item['colors'], true);
            return collect($colors)->pluck('name')->all();
        })->unique()->values()->all();

        $size = $product->flatMap(function ($item) {
            $sizes = json_decode($item['size'], true);
            return collect($sizes)->pluck('name')->all();
        })->unique()->values()->all();

        $getshowmax = $request->max ?? $maxPrice;
        $getshowmin = $request->min ?? $minPrice;
        $getsearch = $request->search ? str_replace('"', ' ', $request->search) : '';
        $getshow = $request->show ?? 0;
        $brands = [];
        $cats = [];
        $urlpages = '/change/@'.$user->slug;
        $sellerPays = PayMeta::where('status',100)->whereHas('product', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $sellerCategory = Category::whereHas('product', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->take(5)->get(['name','slug','image','nameSeo']);
        $comments = Comment::where('type',1)->where('product_id',$user->id)->where('status',1)->with('user')->get();
        $productRate = Comment::where('type',1)->where('product_id',$user->id)->where('status',1)->avg('rate');
        return view('home.single.seller.info', compact('cats','productRate','color','size','comments','sellerCategory','user','sellerPays','getshowmax','getshowmin','getsearch','getshow','urlpages','minPrice','maxPrice','brands'));
    }
    public function sellerChange(Request $request, User $user)
    {
        $product = $user->product()->where('status', 1);

        $sizeId = $request->allSize ? $product->whereJsonContains('size', explode(',', $request->allSize))->pluck('id')->toArray() : [];

        $searchId = $request->search ? $product->where(function ($query) use ($request) {
            $query->where("title", "LIKE", "%{$request->search}%")
                ->orWhere('product_id', $request->search);
        })->pluck('id')->toArray() : [];

        $colorId = $request->allColor ? $product->whereJsonContains('colors', explode(',', $request->allColor))->pluck('id')->toArray() : [];

        $rangeId = $request->max ? $product->whereBetween('price', [$request->min, $request->max])->pluck('id')->toArray() : [];

        $countId = $request->count ? $product->where('count', '!=', '0')->pluck('id')->toArray() : [];

        $arrayFilter = array_filter([$sizeId, $searchId, $colorId, $rangeId, $countId]);

        $currentUrl = url()->current().'?min='.$request->min.'&max='.$request->max.'&show='.$request->show.'&search='.$request->search.'&allSize='.$request->allSize.'&allColor='.$request->allColor;

        if (empty($arrayFilter)) {
            $catPost = $user->product()
                ->orderByRaw('count > 0 DESC')
                ->where("title", "LIKE", "%{$request->search}%")
                ->when($request->show == 0, fn ($query) => $query->latest())
                ->when($request->show == 2, fn ($query) => $query->withCount('payMeta')->orderBy('pay_meta_count', 'DESC'))
                ->when(in_array($request->show, [1, 3]), fn ($query) => $query->withCount('view')->orderByDesc('view_count'))
                ->when(in_array($request->show, [4, 5]), fn ($query) => $query->orderBy('price', $request->show == 4 ? 'asc' : 'desc'))
                ->where('status', 1)
                ->with('user')
                ->paginate(36)->setPath($currentUrl);
        } else {
            $catPost = $user->product()
                ->orderByRaw('count > 0 DESC')
                ->where("title", "LIKE", "%{$request->search}%")
                ->whereIn('id', call_user_func_array('array_intersect', $arrayFilter))
                ->when($request->show == 0, fn ($query) => $query->latest())
                ->when($request->show == 2, fn ($query) => $query->withCount('payMeta')->orderBy('pay_meta_count', 'DESC'))
                ->when(in_array($request->show, [1, 3]), fn ($query) => $query->withCount('view')->orderByDesc('view_count'))
                ->when(in_array($request->show, [4, 5]), fn ($query) => $query->orderBy('price', $request->show == 4 ? 'asc' : 'desc'))
                ->where('status', 1)
                ->whereHas('user', function ($qs) {
                    $qs->whereHas('document', function ($qs) {
                        $qs->where('status',2);
                    });
                })
                ->with('user')
                ->paginate(36)->setPath($currentUrl);
        }

        return $catPost;
    }

    public function blog(News $news){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $this->seoSingleSeo( $news->titleSeo . "$title - " , $news->bodySeo , 'store' , 'blog/'."$news->slug" , $news->image , $news->keywordSeo );

        $related =  News::whereHas('category', function ($q) use ($news){
            return $q->whereIn('name', $news->category()->pluck('name'));
        })->where('id' , '!=' , $news->id)->where('status' , 1)->take(6)->get();
        $suggest = News::where('suggest',1)->inRandomOrder()->where('status',1)->latest()->get();
        $post = News::where('id',$news->id)->with('category','tag')->first();
        return view('home.single.blog' , compact('related','suggest','post'));
    }

    public function getCarrier($product)
    {
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $weights = $product->weight/1000;
        $car = $product->carriers()->first();
        if ($car){
            $allCP = 0;
            foreach (Cart::where('user_id' , $user_id)->where('number' , 0)->get(['product_id','count','price']) as $val){
                $productM = Product::where('id',$val->product_id)->whereHas('carriers', function ($q) use ($car) {
                    $q->where('id', $car->id);
                })->first();
                if($productM){
                    $weights += ($productM['weight'] * $val->count)/1000;
                    $allCP += ($val->price * $val->count);
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
        }else{
            return 0;
        }
    }
}
