<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use App\Models\Brand;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\PriceChange;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Time;
use App\Models\Video;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->with('category')->where('user_id' , auth()->id())->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $products = Product::with('category')->where('user_id' , auth()->id())->latest()->paginate(50)->setPath($currentUrl);
        }
        $tab = 2;
        return view('seller.post.index',compact('products','title','tab'));
    }
    public function create(){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $posts = '';
        $carriers = Carrier::select(['id' , 'name','price'])->where('user_id' , auth()->id())->latest()->get();
        return view('seller.post.create',compact('cats','tags','brands','posts','carriers','guarantees'));
    }
    public function digikala(){
        $check = Auto::where('user_id',auth()->user()->id)->where('status',0)->where('type',0)->value('link');
        return view('seller.post.digikala',compact('check'));
    }
    public function digikalaStore(Request $request){
        $request->validate([
            'link' => 'required|max:400',
        ]);
        if (Auto::where('user_id',auth()->user()->id)->where('status',0)->where('type',0)->first()){
            return redirect()->back()->with([
                'error' => 'یک لینک در حال بررسی وجود , منتظر بمانید.'
            ]);
        }
        $link = Auto::where('user_id',auth()->user()->id)->latest()->where('type',0)->first();
        if($link){
            $link->update([
                'link' => $request->link,
                'status' => 0,
            ]);
        }else{
            Auto::create([
                'link' => $request->link,
                'status' => 0,
                'user_id' => auth()->user()->id,
                'type' => 0,
            ]);
        }
        return redirect()->back()->with([
            'message' => 'بعد از بررسی و تایید , ربات خودکار محصولات را در پنل شما اضافه خواهد کرد.'
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'count' => 'required|integer|digits_between: 1,5',
            'price' => 'required|integer|digits_between: 1,9',
            'time' => 'required|integer|min:1|max:100',
            'prepare' => 'required|integer|min:1|max:100',
            'weight' => 'required|integer|digits_between: 1,9',
            'carriers' => 'required|integer|digits_between: 1,9',
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
            'status' => 0,
            'slug' => $request->slug,
            'image' => $request->image,
            'price' => $price,
            'offPrice' => $request->price,
            'off' => $request->off,
            'user_id' => auth()->id(),
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
    public function edit(Product $product){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $carriers = Carrier::select(['id' , 'name','price'])->where('user_id' , auth()->id())->latest()->get();
        $posts = Product::where('id' , $product->id)->with('category','tag','carriers','guarantee','brand')->first();
        return view('seller.post.edit',compact('cats','tags','carriers','brands','guarantees','posts'));
    }
    public function copy(Product $product){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $brands = Brand::select(['id' , 'name'])->latest()->get();
        $guarantees = Guarantee::select(['id' , 'name'])->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 0)->latest()->get();
        $carriers = Carrier::select(['id' , 'name','price'])->where('user_id' , auth()->id())->latest()->get();
        $posts = Product::where('id' , $product->id)->with('category','carriers','tag','guarantee','brand')->first();
        return view('seller.post.create',compact('cats','tags','carriers','brands','guarantees','posts'));
    }
    public function update(Product $product,Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'count' => 'required|integer|digits_between: 1,5',
            'price' => 'required|integer|digits_between: 1,9',
            'time' => 'required|integer|min:1|max:100',
            'prepare' => 'required|integer|min:1|max:100',
            'weight' => 'required|integer|digits_between: 1,9',
            'carriers' => 'required|integer|digits_between: 1,9',
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
        $post = $product->update([
            'count' => $request->count,
            'title' => $request->title,
            'showcase' => $showcase,
            'used' => $used,
            'inquiry' => $inquiry,
            'weight' => $request->weight,
            'prepare' => $request->prepare,
            'time' => $request->time,
            'original' => $original,
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
    public function change(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $products = Product::where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->where('user_id',auth()->id())->select(['id','title','slug','count','offPrice','off','score','weight','status','showcase','original','inquiry','prepare','time','body'])->latest()->paginate(100)->setPath($currentUrl);
        }else{
            $products = Product::where('user_id',auth()->id())->select(['id','title','slug','count','offPrice','off','score','weight','status','showcase','original','inquiry','prepare','time','body'])->latest()->paginate(100)->setPath($currentUrl);
        }
        return view('seller.post.change',compact('products','title'));
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
                'count' => $item->count,
                'offPrice' => $item->offPrice,
                'off' => $item->off != '' ? $item->off : null,
                'weight' => $item->weight != '' ? $item->weight : 10,
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
}
