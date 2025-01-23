<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $links = Link::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->where('parent_id' , 0)->select(['name' , 'id'])->orderBy('number')->paginate(50)->setPath($currentUrl);
        }else{
            $links = Link::select(['name' , 'id'])->where('parent_id' , 0)->orderBy('number')->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.link' , compact('links','title'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'slug' => 'required',
        ]);
        $post = Link::create([
            'name' => $request->name,
            'number' => Link::count(),
            'parent_id' => 0,
            'slug' => $request->slug,
            'type' => $request->type,
        ]);
        return redirect()->back()->with([
            'message' => 'لینک با موفقیت اضافه شد'
        ]);
    }
    public function edit(Link $link){
        return $link;
    }
    public function update(Link $link , Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'slug' => 'required',
        ]);
        $link->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'type' => $request->type,
        ]);
        return redirect()->back()->with([
            'message' => 'لینک ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Link $link){
        $link->delete();
        return redirect()->back()->with([
            'message' => 'لینک با موفقیت حذف شد'
        ]);
    }
    public function changeLink(Request $request){
        $num = 0;
        foreach (json_decode($request->links) as $item){
            $num++;
            Link::where('id' , $item->mine)->first()->update([
                'number' => $num,
                'parent_id' => !empty($item->parent)?$item->parent:0,
            ]);
        }
        return 'ok';
    }
}
