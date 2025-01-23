<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(){
        $logoSite = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        $sitemap = Sitemap::create();
        foreach (Product::latest()->where('status' , 1)->get() as $item){
            $sitemap->add(Url::create(url('/product/'.$item->slug))->addImage(count(explode('https' , json_decode($item->image)[0])) == 1?url(json_decode($item->image)[0]):json_decode($item->image)[0], $item->title));
        }
        foreach (Category::latest()->where('type' , 0)->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/category/'.$item->slug))->addImage($image, $item->name));
        }
        foreach (Category::latest()->where('type' , 1)->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/blog/category/'.$item->slug))->addImage($image, $item->name));
        }
        foreach (Tag::latest()->where('type' , 0)->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/tag/'.$item->slug))->addImage($image, $item->name));
        }
        foreach (Tag::latest()->where('type' , 1)->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/blog/tag/'.$item->slug))->addImage($image, $item->name));
        }
        foreach (Brand::latest()->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/brand/'.$item->slug))->addImage($image, $item->name));
        }
        foreach (Page::latest()->get() as $item){
            $image = $item->image ? count(explode('https' , $item->image)) == 1?url($item->image):$item->image : $logoSite;
            $sitemap->add(Url::create(url('/page/'.$item->slug))->addImage($image, $item->title));
        }
        return $sitemap->writeToFile($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml');
    }
}
