<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        $redirects = Redirect::select(['start','end' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        return view('admin.taxonomy.index.redirect' , compact('redirects','title'));
    }
    public function store(Request $request){
        $request->validate([
            'start' => 'required|max:500',
            'end' => 'required|max:500',
        ]);
        $post = Redirect::create([
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type,
        ]);
        return redirect()->back()->with([
            'message' => 'ریدایرکت با موفقیت اضافه شد'
        ]);
    }
    public function edit(Redirect $redirect){
        return $redirect;
    }
    public function update(Redirect $redirect , Request $request){
        $request->validate([
            'start' => 'required|max:500',
            'end' => 'required|max:500',
        ]);
        $redirect->update([
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type,
        ]);
        return redirect()->back()->with([
            'message' => 'ریدایرکت ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Redirect $redirect){
        $redirect->delete();
        return redirect()->back()->with([
            'message' => 'ریدایرکت با موفقیت حذف شد'
        ]);
    }
}
