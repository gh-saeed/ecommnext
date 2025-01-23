<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $tags = Tag::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $tags = Tag::select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.tag' , compact('tags','title'));
    }
    public function show(Request $request , Tag $tag){
        $tags = Tag::where('id' , $tag->id)->with('product','blogs')->first();
        return view('admin.taxonomy.show.tag' , compact('tags'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'nameSeo' => 'required|max:220',
            'keyword' => 'required|max:220',
            'bodySeo' => 'required',
        ]);
        $post = Tag::create([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'bodySeo' => $request->bodySeo,
            'image' => $request->image,
            'type' => $request->type,
            'language' => $request->language,
            'slug' => $request->slug,
            'keyword' => $request->keyword,
        ]);
        return redirect()->back()->with([
            'message' => 'برچسب با موفقیت اضافه شد'
        ]);
    }
    public function edit(Tag $tag){
        return Tag::where('id' , $tag->id)->first();
    }
    public function update(Tag $tag , Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'nameSeo' => 'required|max:220',
            'keyword' => 'required|max:220',
            'bodySeo' => 'required',
        ]);
        if($tag->slug != $request->slug){
            if($tag->type == 0){
                Redirect::create([
                    'start' => url('/tag/'.$tag->slug),
                    'end' => url('/tag/'.$request->slug),
                    'type' => 301,
                ]);
            }else{
                if($tag->slug != $request->slug){
                    Redirect::create([
                        'start' => url('/blog/tag/'.$tag->slug),
                        'end' => url('/blog/tag/'.$request->slug),
                        'type' => 301,
                    ]);
                }
            }
        }
        $tag->update([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'bodySeo' => $request->bodySeo,
            'type' => $request->type,
            'language' => $request->language,
            'image' => $request->image,
            'slug' => $request->slug,
            'keyword' => $request->keyword,
        ]);
        return redirect()->back()->with([
            'message' => 'برچسب ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Tag $tag){
        if($tag->type == 0){
            Redirect::create([
                'start' => url('/tag/'.$tag->slug),
                'end' => url(''),
                'type' => 410,
            ]);
        }else{
            Redirect::create([
                'start' => url('/blog/tag/'.$tag->slug),
                'end' => url(''),
                'type' => 410,
            ]);
        }
        $tag->product()->detach();
        $tag->delete();
        return redirect()->back()->with([
            'message' => 'برچسب با موفقیت حذف شد'
        ]);
    }
}
