<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$request->title;
        if($request->title){
            $stories = Story::where(function ($query) use($title) {
                $query->where('title', $title)
                    ->orWhere('id', $title);
            })->select(['id' , 'title' , 'cover' , 'created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $stories = Story::select(['id' , 'title' , 'cover' , 'created_at'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.story.index',compact('stories','title'));
    }
    public function create(){
        return view('admin.story.create');
    }
    public function edit(Story $story){
        return view('admin.story.edit',compact('story'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'image' => 'required',
            'cover' => 'required',
        ]);
        $post = Story::create([
            'title' => $request->title,
            'image' => $request->image,
            'cover' => $request->cover,
            'type' => $request->type,
            'user_id' => auth()->id(),
        ]);
    }
    public function update(Story $story,Request $request){
        $request->validate([
            'title' => 'required|max:220',
            'image' => 'required',
            'cover' => 'required',
        ]);
        $story->update([
            'title' => $request->title,
            'image' => $request->image,
            'cover' => $request->cover,
            'type' => $request->type,
        ]);
        return 'success';
    }
    public function delete(Story $story){
        $story->delete();
        return redirect()->back()->with([
            'message' => 'استوری با موفقیت حذف شد'
        ]);
    }
}
