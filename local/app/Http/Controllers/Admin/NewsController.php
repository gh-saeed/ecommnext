<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Field;
use App\Models\FieldData;
use App\Models\News;
use App\Models\Redirect;
use App\Models\Tag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $blogs = News::where(function ($query) use($title) {
                $query->where('title' , "LIKE" , "%{$title}%")
                    ->orWhere('id', $title);
            })->select(['id' , 'title' , 'image' , 'created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $blogs = News::select(['id' , 'title' , 'image' , 'created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.blog.index',compact('blogs','title'));
    }
    public function create(){
        $cats = Category::select(['id' , 'name'])->where('type' , 1)->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 1)->latest()->get();
        return view('admin.blog.create',compact('cats','tags'));
    }
    public function edit(News $news){
        $cats = Category::select(['id' , 'name'])->where('type' , 1)->latest()->get();
        $tags = Tag::select(['id' , 'name'])->where('type' , 1)->latest()->get();
        $posts = News::where('id' , $news->id)->with('category','tag')->first();
        return view('admin.blog.edit',compact('cats','tags','posts'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'status' => 'required',
            'time' => 'required',
        ]);
        $suggest = $request->suggest == 'true' ? 1 : 0;

        $post = News::create([
            'title' => $request->title,
            'suggest' => $suggest,
            'status' => $request->status,
            'slug' => $request->slug,
            'time' => $request->time,
            'image' => $request->image,
            'titleSeo' => $request->titleSeo,
            'bodySeo' => $request->bodySeo,
            'video' => $request->video,
            'keyword' => $request->keywordSeo,
            'imageAlt' => $request->imageAlt,
            'user_id' => auth()->user()->id,
            'body' => $request->body,
        ]);
        $post->category()->sync(json_decode($request->cats));
        $post->tag()->sync(json_decode($request->tags));
    }
    public function update(News $news,Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'status' => 'required',
        ]);
        $suggest = $request->suggest == 'true' ? 1 : 0;
        if($news->slug != $request->slug){
            Redirect::create([
                'start' => url('/blog/'.$news->slug),
                'end' => url('/blog/'.$request->slug),
                'type' => 301,
            ]);
        }
        $post = $news->update([
            'title' => $request->title,
            'suggest' => $suggest,
            'status' => $request->status,
            'slug' => $request->slug,
            'time' => $request->time,
            'image' => $request->image,
            'titleSeo' => $request->titleSeo,
            'video' => $request->video,
            'bodySeo' => $request->bodySeo,
            'keyword' => $request->keywordSeo,
            'imageAlt' => $request->imageAlt,
            'language' => $request->language,
            'user_id' => auth()->user()->id,
            'body' => $request->body,
        ]);
        $news->category()->detach();
        $news->tag()->detach();
        $news->category()->sync(json_decode($request->cats));
        $news->tag()->sync(json_decode($request->tags));
        return 'success';
    }
    public function show(News $news){
        $posts = News::where('id' , $news->id)->with('category','tag')->first();
        return view('admin.blog.show',compact('posts'));
    }
    public function delete(News $news){
        Redirect::create([
            'start' => url('/blog/'.$news->slug),
            'end' => url(''),
            'type' => 410,
        ]);
        $news->category()->detach();
        $news->tag()->detach();
        $news->delete();
        return redirect()->back()->with([
            'message' => 'بلاگ با موفقیت حذف شد'
        ]);
    }
}
