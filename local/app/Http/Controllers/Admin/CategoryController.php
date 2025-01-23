<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Redirect;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $categories = Category::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $categories = Category::select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        $cats = Category::select(['name' , 'id'])->latest()->get();
        $brands = Brand::select(['name' , 'id'])->latest()->get();
        return view('admin.taxonomy.index.category' , compact('categories','brands','cats','title'));
    }
    public function show(Request $request , Category $category){
        $categories = Category::where('id' , $category->id)->with('product','blogs')->first();
        return view('admin.taxonomy.show.category' , compact('categories'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        $post = Category::create([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'bodySeo' => $request->bodySeo,
            'percent' => $request->percent ?? 0,
            'image' => $request->image,
            'slug' => $request->slug,
            'type' => $request->type,
            'keyword' => $request->keyword,
        ]);
        $post->cats()->attach($request->cats);
        $post->mother()->attach($request->mother);
        $post->brands()->attach($request->brands);
        return redirect()->back()->with([
            'message' => 'دسته بندی با موفقیت اضافه شد'
        ]);
    }
    public function edit(Category $category){
        return Category::where('id' , $category->id)->with('cats','mother','brands')->first();
    }
    public function update(Category $category , Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        if($category->slug != $request->slug){
            if($category->type == 0){
                Redirect::create([
                    'start' => url('/category/'.$category->slug),
                    'end' => url('/category/'.$request->slug),
                    'type' => 301,
                ]);
            }else{
                if($category->slug != $request->slug){
                    Redirect::create([
                        'start' => url('/blog/category/'.$category->slug),
                        'end' => url('/blog/category/'.$request->slug),
                        'type' => 301,
                    ]);
                }
            }
        }
        $category->update([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'bodySeo' => $request->bodySeo,
            'percent' => $request->percent ?? 0,
            'image' => $request->image,
            'type' => $request->type,
            'slug' => $request->slug,
            'keyword' => $request->keyword,
        ]);
        $category->cats()->detach();
        $category->brands()->detach();
        $category->mother()->detach();
        $category->cats()->attach($request->cats);
        $category->mother()->attach($request->mother);
        $category->brands()->attach($request->brands);
        return redirect()->back()->with([
            'message' => 'دسته بندی ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Category $category){
        if($category->type == 0){
            Redirect::create([
                'start' => url('/category/'.$category->slug),
                'end' => url(''),
                'type' => 410,
            ]);
        }else{
            Redirect::create([
                'start' => url('/blog/category/'.$category->slug),
                'end' => url(''),
                'type' => 410,
            ]);
        }
        $category->product()->detach();
        $category->cats()->detach();
        $category->mother()->detach();
        $category->delete();
        return redirect()->back()->with([
            'message' => 'دسته بندی با موفقیت حذف شد'
        ]);
    }
}
