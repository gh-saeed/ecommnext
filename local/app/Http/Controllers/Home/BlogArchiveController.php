<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Setting;
use App\Models\Tag;
use App\Traits\SeoHelper;
use Illuminate\Http\Request;

class BlogArchiveController extends Controller
{
    use SeoHelper;
    public function blogs(){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $shortActivity = Setting::where('key' , 'aboutSeo')->pluck('value')->first() ?:'' ;
        $keyword = Setting::where('key' , 'keyword')->pluck('value')->first() ?: [] ;
        $logoSite = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        $this->seoSingleSeo( __('messages.blogs') . "$title - " , $shortActivity , 'store' , 'blogs' , $logoSite , $keyword );

        $suggest = News::where('status' , 1)->where('suggest' , 1)->with('user')->latest()->take(6)->get();
        $news = News::where('status' , 1)->latest()->with('user')->paginate(70);
        $category = json_decode(json_encode(["name"=>__('messages.blogs'),"body"=>$shortActivity]));
        return view('home.archive.news' , compact(
            'news',
            'suggest',
            'category',
        ));
    }
    public function category(Category $category){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $this->seoSingleSeo( $category->nameSeo . "$title - " , $category->bodySeo , 'store' , 'blog/category/'."$category->slug" , $category->image , $category->keyword );

        $suggest = $category->blogs()->where('status' , 1)->where('suggest' , 1)->with('user')->latest()->take(6)->get();
        $news = $category->blogs()->where('status' , 1)->latest()->with('user')->paginate(70);
        return view('home.archive.news' , compact(
            'news',
            'suggest',
            'category',
        ));
    }
    public function tag(Tag $tag){
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $this->seoSingleSeo( $tag->nameSeo . "$title - " , $tag->bodySeo , 'store' , 'blog/tag/'."$tag->slug" , $tag->image , $tag->keyword );

        $suggest = $tag->blogs()->where('status' , 1)->where('suggest' , 1)->with('user')->latest()->take(6)->get();
        $news = $tag->blogs()->where('status' , 1)->latest()->with('user')->paginate(70);
        $category = $tag;
        return view('home.archive.news' , compact(
            'news',
            'suggest',
            'category',
        ));
    }
}
