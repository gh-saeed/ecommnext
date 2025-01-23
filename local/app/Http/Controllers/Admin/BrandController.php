<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Redirect;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $brands = Brand::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $brands = Brand::select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.brand' , compact('brands','title'));
    }
    public function show(Request $request , Brand $brand){
        $brands = Brand::where('id' , $brand->id)->with('product')->first();
        return view('admin.taxonomy.show.brand' , compact('brands'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'nameSeo' => 'required|max:220',
            'keyword' => 'required|max:220',
            'bodySeo' => 'required',
        ]);
        $post = Brand::create([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'bodySeo' => $request->bodySeo,
            'language' => $request->language,
            'image' => $request->image,
            'slug' => $request->slug,
            'keyword' => $request->keyword,
        ]);
        return redirect()->back()->with([
            'message' => 'برند با موفقیت اضافه شد'
        ]);
    }
    public function edit(Brand $brand){
        return $brand;
    }
    public function update(Brand $brand , Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'nameSeo' => 'required|max:220',
            'keyword' => 'required|max:220',
            'bodySeo' => 'required',
        ]);
        if($brand->slug != $request->slug){
            Redirect::create([
                'start' => url('/brand/'.$brand->slug),
                'end' => url('/brand/'.$request->slug),
                'type' => 301,
            ]);
        }
        $brand->update([
            'name' => $request->name,
            'nameSeo' => $request->nameSeo,
            'body' => $request->body,
            'language' => $request->language,
            'bodySeo' => $request->bodySeo,
            'image' => $request->image,
            'slug' => $request->slug,
            'keyword' => $request->keyword,
        ]);
        return redirect()->back()->with([
            'message' => 'برند ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Brand $brand){
        $post = Redirect::create([
            'start' => url('/brand/'.$brand->slug),
            'end' => url(''),
            'type' => 410,
        ]);
        $brand->product()->detach();
        $brand->delete();
        return redirect()->back()->with([
            'message' => 'برند با موفقیت حذف شد'
        ]);
    }
}
