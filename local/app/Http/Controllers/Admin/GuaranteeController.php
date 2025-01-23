<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guarantee;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $guarantees = Guarantee::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $guarantees = Guarantee::select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.guarantee' , compact('guarantees','title'));
    }
    public function show(Request $request , Guarantee $guarantee){
        $guarantees = Guarantee::where('id' , $guarantee->id)->with('product')->first();
        return view('admin.taxonomy.show.guarantee' , compact('guarantees'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        $post = Guarantee::create([
            'name' => $request->name,
            'language' => $request->language,
        ]);
        return redirect()->back()->with([
            'message' => 'گارانتی با موفقیت اضافه شد'
        ]);
    }
    public function edit(Guarantee $guarantee){
        return $guarantee;
    }
    public function update(Guarantee $guarantee , Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        $guarantee->update([
            'name' => $request->name,
            'language' => $request->language,
        ]);
        return redirect()->back()->with([
            'message' => 'گارانتی ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Guarantee $guarantee){
        $guarantee->product()->detach();
        $guarantee->delete();
        return redirect()->back()->with([
            'message' => 'گارانتی با موفقیت حذف شد'
        ]);
    }
}
