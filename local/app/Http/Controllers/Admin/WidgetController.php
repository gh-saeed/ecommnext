<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use App\Models\Widget;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    public function index(){
        $widgets = Widget::orderBy('number')->where('user_id',0)->where('responsive' , 0)->select(['id','name','title','status'])->get();
        $type = 0;
        return view('admin.widget.index',compact('widgets','type'));
    }
    public function mobileIndex(){
        $widgets = Widget::orderBy('number')->where('user_id',0)->where('responsive' , 1)->select(['id','name','title','status'])->get();
        $type = 1;
        return view('admin.widget.index',compact('widgets','type'));
    }
    public function change(Request $request){
        for ( $i = 0; $i < count($request->widget); $i++) {
            Widget::where('id' , $request->widget[$i])->where('user_id',0)->where('responsive' , $request->type)->update([
                'number' => $i
            ]);
        }
        return 'success';
    }
    public function create(){
        $cats = Category::select(['id','name'])->where('type',0)->get();
        $users = User::select(['id','name'])->get();
        $brands = Brand::select(['id','name'])->get();
        return view('admin.widget.create',compact('cats','users' , 'brands'));
    }
    public function edit(Widget $widget){
        $cats = Category::select(['id','name'])->where('type',0)->get();
        $brands = Brand::select(['id','name'])->get();
        $users = User::select(['id','name'])->get();
        $catId = [];
        $brandId = [];
        $userId = [];
        if($widget['brands'] != '[]'){
            $brandId = json_decode($widget['brands'],true);
        }
        if($widget['cats'] != '[]'){
            $catId = json_decode($widget['cats'],true);
        }
        if($widget['users'] != '[]'){
            $userId = json_decode($widget['users'],true);
        }
        return view('admin.widget.edit',compact('cats' , 'catId' , 'userId','users' , 'brandId' , 'brands','widget'));
    }
    public function store(Request $request){
        $widget = Widget::orderBy('number','DESC')->where('responsive' , $request->responsive)->pluck('number')->first();
        if($widget){
            $number = (int)$widget++;
        }else{
            $number = 0;
        }
        Widget::create([
            'name'=> $request->name,
            'title'=> $request->title,
            'more'=> $request->more,
            'description'=> $request->description,
            'background'=> $request->background,
            'slug'=> $request->slug,
            'count'=> $request->count,
            'sort'=> $request->sort,
            'type'=> $request->type,
            'status'=> $request->status,
            'brands'=> $request->brands,
            'users'=> $request->users,
            'responsive'=> $request->responsive,
            'number'=> $number,
            'cats'=> $request->cats,
            'ads1'=> $request->ads1,
            'ads2'=> $request->ads2,
            'ads3'=> $request->ads3,
        ]);
        return 'success';
    }
    public function update(Request $request , Widget $widget){
        $widget->update([
            'name'=> $request->name,
            'title'=> $request->title,
            'more'=> $request->more,
            'description'=> $request->description,
            'background'=> $request->background,
            'slug'=> $request->slug,
            'count'=> $request->count,
            'sort'=> $request->sort,
            'type'=> $request->type,
            'status'=> $request->status,
            'brands'=> $request->brands,
            'users'=> $request->users,
            'responsive'=> $request->responsive,
            'cats'=> $request->cats,
            'ads1'=> $request->ads1,
            'ads2'=> $request->ads2,
            'ads3'=> $request->ads3,
        ]);
        return 'success';
    }
    public function delete(Widget $widget){
        $widget->delete();
        return redirect()->back()->with([
            'message' => 'ویجت با موفقیت حذف شد'
        ]);
    }
}
