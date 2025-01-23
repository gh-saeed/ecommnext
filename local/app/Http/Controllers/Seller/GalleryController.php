<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request){
        $currentUrl = url()->current().'?container='.$request->container;
        if ($request->container == 0){
            $galleries = Gallery::latest()->where('user_id' , auth()->user()->id)->latest()->paginate(40)->setPath($currentUrl);
        }
        if ($request->container == 1){
            $galleries = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['gif','jpeg','jpg','png','svg','tif','jfif'])->paginate(40)->setPath($currentUrl);
        }
        if ($request->container == 2){
            $galleries = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['rar','zip'])->paginate(40)->setPath($currentUrl);
        }
        if ($request->container == 3){
            $galleries = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['mp4','mkv'])->paginate(40)->setPath($currentUrl);
        }
        if ($request->container == 4){
            $galleries = Gallery::latest()->where('user_id' , auth()->user()->id)->where('status' , 2)->paginate(40)->setPath($currentUrl);
        }
        $count1 = Gallery::latest()->where('user_id' , auth()->user()->id)->count();
        $count2 = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['gif','jpeg','jpg','png','svg','tif','jfif'])->count();
        $count3 = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['rar','zip'])->count();
        $count4 = Gallery::latest()->where('user_id' , auth()->user()->id)->whereIn('type', ['mp4','mkv'])->count();
        if($count1){
            $percent1 = round(($count1 * '100') / $count1);
            $percent2 = round(($count2 * '100') / $count1);
            $percent3 = round(($count3 * '100') / $count1);
            $percent4 = round(($count4 * '100') / $count1);
        }else{
            $percent1 = 0;
            $percent2 = 0;
            $percent3 = 0;
            $percent4 = 0;
        }
        return view('seller.gallery.index' , compact(
            'count1',
            'count2',
            'count3',
            'count4',
            'percent1',
            'percent2',
            'percent3',
            'percent4',
            'galleries'
        ));
    }

    public function upload(Request $request){
        $folder = $_SERVER['DOCUMENT_ROOT']."/upload/user/" . auth()->user()->id . '/';
        if (!file_exists($folder)){
            mkdir($folder , 0755 , true);
        }
        $file = $request->image;
        $name = $file->getClientOriginalName();
        $type = $file->getClientOriginalExtension();
        $sizefile = $file->getsize()/1000;
        if( $sizefile > 1000){
            $size=round($sizefile/1000 ,2) . 'mb';
        }else{
            $size=round($sizefile) . 'kb';
        }
        $url = "/upload/user/" . auth()->user()->id;
        if ($type == "jpg" or $type == "JPG" or $type == "png" or $type == "PNG" or $type == "jpeg" or $type == "svg" or $type == "tif" or $type == "gif" or $type == "jfif"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "rar" or $type == "zip"){
            $path = $file->move(storage_path($url) , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "mp3"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'type' => $type,
                'user_id' => auth()->user()->id,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        elseif ($type == "mp4" or $type == "mkv"){
            $path = $file->move($_SERVER['DOCUMENT_ROOT'] .$url , $name);
            $img = Gallery::create([
                'name' => $name,
                'size' => $size,
                'user_id' => auth()->user()->id,
                'type' => $type,
                'url' => $url . '/' . $name ,
                'path' => $path->getRealPath(),
            ]);
        }
        return $img;
    }
    public function getImage(){
        return Gallery::latest()->where('user_id' , auth()->user()->id)->take(500)->pluck('url');
    }
    public function deleteImage(Gallery $gallery){
        $gallery2 = Gallery::where('id' , $gallery->id)->where('user_id' , auth()->user()->id)->first();
        $gallery2->delete();
        return redirect()->back()->with([
            'message' => __('messages.pic_deleted')
        ]);
    }
}
