<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use App\Models\Widget;
use App\Traits\SeoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    use SeoHelper;
    public function blogs(){
        $shortActivity = Setting::where('key' , 'aboutSeo')->pluck('value')->first() ?:'' ;
        $keyword = Setting::where('key' , 'keyword')->pluck('value')->first() ?: [] ;
        $logoSite = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        $this->seoSingleSeo( 'بلاگ ها' , $shortActivity , 'store' , 'blog' , $logoSite , $keyword );

        $news = News::where('status' , 1)->latest()->with('user')->paginate(70);
        $category = json_decode(json_encode(["name"=>'بلاگ ها',"body"=>$shortActivity]));
        return view('home.archive.news' , compact(
            'news',
            'category',
        ));
    }
    public function blogCategory(Category $category){
        $this->seoSingleSeo( $category->nameSeo , $category->bodySeo , 'store' , 'blog/category/'."$category->slug" , $category->image , $category->keyword );
        $news = $category->blogs()->where('status' , 1)->latest()->with('user')->paginate(70);
        return view('home.archive.news' , compact(
            'news',
            'category',
        ));
    }
    public function mother(Category $category){
        $this->seoSingleSeo( $category->nameSeo , $category->bodySeo , 'store' , 'mother-category/'."$category->slug" , $category->image , $category->keyword );
        $subCats = $category->cats;
        $betSell = $category->product()
            ->orderByRaw('count > 0 DESC')
            ->withCount('payMeta')->orderBy('pay_meta_count', 'DESC')
            ->where('status', 1)
            ->take(10)->get();
        $newProduct = $category->product()
            ->orderByRaw('count > 0 DESC')
            ->latest()
            ->where('status', 1)
            ->take(10)->get();
        $freeCarrier = $category->product()
            ->orderByRaw('count > 0 DESC')
            ->whereHas('carriers', function ($q) {
                $q->where('price', 0);
            })
            ->where('status', 1)
            ->take(10)->get();
        $sellers = User::whereHas('document', function ($q) {
                $q->where('status', 2);
            })
            ->whereHas('product', function ($q) use ($category) {
                $q->whereHas('category', function ($q) use ($category) {
                        $q->where('id', $category->id);
                    });
            })->take(5)->get();
        return view('home.archive.mother',compact('category','subCats','newProduct','sellers','betSell','freeCarrier'));
    }
    public function category(Category $category,Request $request)
    {
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $this->seoSingleSeo( $category->nameSeo . " - $title" , $category->bodySeo , 'store' , 'category/'."$category->slug" , $category->image , $category->keyword );
        $product = $category->product()->where('status',1)->get();
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

        $brands = $category->brands;

        $cats = $category->cats;
        $urlpages = '/change/category/'.$category->slug;
        $archive = Category::where('id' , $category->id)->first();
        return view('home.archive.product', compact('cats','archive','color','size','getshowmax','getshowmin','getsearch','getshow','urlpages','minPrice','maxPrice','brands'));
    }
    public function categoryChange(Request $request, Category $category)
    {
        if (!$request->ajax()) {
            return redirect(str_replace('/change','',$request->fullUrl()));
        }
        $product = $category->product()->where('status', 1);

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
            $catPost = $category->product()
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
            $catPost = $category->product()
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
    public function brand(Brand $brand,Request $request){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $this->seoSingleSeo( $brand->nameSeo, $brand->bodySeo , 'store' , 'brand/'."$brand->slug" , $brand->image , $brand->keyword );
        $product = $brand->product()->where('status',1)->get();
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
        $urlpages = '/change/brand/'.$brand->slug;
        $archive = Brand::where('id' , $brand->id)->first();
        return view('home.archive.product', compact('cats','archive','color','size','getshowmax','getshowmin','getsearch','getshow','urlpages','minPrice','maxPrice','brands'));
    }
    public function brandChange(Request $request, Brand $brand)
    {
        if (!$request->ajax()) {
            return redirect(str_replace('/change','',$request->fullUrl()));
        }
        $product = $brand->product()->where('status', 1);

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
            $catPost = $brand->product()
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
            $catPost = $brand->product()
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
    public function search(Request $request){
        $logoSite = Setting::where('key' , 'logo')->value('value') ?:'' ;
        $about = Setting::where('key' , 'about')->value('value') ?:'' ;
        $keyword = Setting::where('key' , 'keyword')->value('value') ?: [] ;
        $title = Setting::where('key' , 'title')->value('value');
        $this->seoSingleSeo( 'جستجو' , 'جستجو محصول' , 'store' , 'search?search='.str_replace('"', ' ', $request->search) , $logoSite , $keyword );
        $product = Product::where("title" , "LIKE" , "%{$request->search}%")
            ->where('status', 1)
            ->get();
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
        $urlpages = '/change/search';
        $archive = json_decode(json_encode(["name"=>($getsearch!=''?$getsearch:$title),"nameSeo"=>($getsearch!=''?$getsearch:$title),"body"=>$about]));
        return view('home.archive.product', compact('cats','archive','color','size','getshowmax','getshowmin','getsearch','getshow','urlpages','minPrice','maxPrice','brands'));
    }
    public function searchChange(Request $request)
    {
        if (!$request->ajax()) {
            return redirect(str_replace('/change','',$request->fullUrl()));
        }
        $product = Product::where("title" , "LIKE" , "%{$request->search}%")->where('status', 1);

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
            $catPost = Product::orderByRaw('count > 0 DESC')
                ->where("title", "LIKE", "%{$request->search}%")
                ->when($request->show == 0, fn ($query) => $query->latest())
                ->when($request->show == 2, fn ($query) => $query->withCount('payMeta')->orderBy('pay_meta_count', 'DESC'))
                ->when(in_array($request->show, [1, 3]), fn ($query) => $query->withCount('view')->orderByDesc('view_count'))
                ->when(in_array($request->show, [4, 5]), fn ($query) => $query->orderBy('price', $request->show == 4 ? 'asc' : 'desc'))
                ->where('status', 1)
                ->with('user')
                ->paginate(36)->setPath($currentUrl);
        } else {
            $catPost = Product::orderByRaw('count > 0 DESC')
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
    public function discovery(){
        $products = Product::where('status',1)->latest()->select(['title','price','image','slug'])->paginate(10);
        $stories = Story::latest()->has('user')->with('user')->select(['title','user_id','updated_at','id','image','cover','type'])->paginate(10);
        $categories = Category::latest()->has('product')->with('brands')->where('type',0)->paginate(10);
        $bazar = $products->concat($stories)->concat($categories)->shuffle();
        return view('home.archive.discovery',compact('bazar'));
    }
    public function changeDiscovery(){
        $products = Product::where('status',1)->latest()->select(['title','price','image','slug'])->paginate(10);
        $stories = Story::latest()->has('user')->with('user')->select(['title','user_id','updated_at','id','image','cover','type'])->paginate(10);
        $categories = Category::latest()->with('brands')->has('product')->where('type',0)->paginate(10);
        return $products->concat($stories)->concat($categories)->shuffle();
    }
    public function shops(Request $request){
        $urlpages = '/change/shops/';
        return view('home.archive.shops',compact('urlpages'));
    }
    public function changeShops(Request $request){
        if (!$request->ajax()) {
            return redirect(str_replace('/change','',$request->fullUrl()));
        }
        $currentUrl = str_replace(url(''), '', request()->fullUrl());
        return User::latest()->where('seller','!=',0)->with('documentSuccess')
            ->when($request->search, fn ($query) => $query->where("name", "LIKE", "%{$request->search}%"))
            ->select(['name','city','id','slug','profile'])->withAvg('comments','rate')->has('documentSuccess')->paginate(40)->setPath($currentUrl);
    }
}
