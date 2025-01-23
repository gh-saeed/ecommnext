<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ChangePrice;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ChangeController extends Controller
{
    public function excel(){
        return view('admin.change.excel');
    }
    public function increase(){
        $brands = Brand::latest()->select(['name','id'])->get();
        $cats = Category::latest()->select(['name','id'])->get();
        $products = Product::latest()->select(['title','id'])->get();
        $routes = 'increase';
        return view('admin.change.index',compact('brands','routes','cats','products'));
    }
    public function decrease(){
        $brands = Brand::latest()->select(['name','id'])->get();
        $cats = Category::latest()->select(['name','id'])->get();
        $products = Product::latest()->select(['title','id'])->get();
        $routes = 'decrease';
        return view('admin.change.index',compact('brands','routes','cats','products'));
    }
    public function changePriceExcel(Request $request){
        $file = $request->image;
        $import = new ChangePrice();
        Excel::import($import, $file);
        return 'success';
    }
    public function increasePrice(Request $request){
        if($request->type == 0){
            foreach($request->brands as $item){
                $bProduct = Brand::where('id' , $item)->first();
                foreach($bProduct->product as $product){
                    if($request->percent){
                        $amount = (int)$product->offPrice + (int)(($product->offPrice * $request->percent) / 100);
                    }elseif($request->number){
                        $amount = (int)$product->offPrice + (int)$request->number;
                    }else{
                        $amount = (int)$product->offPrice;
                    }
                    $product->update([
                        'offPrice' => $amount,
                        'price' => $amount,
                        'off' => '',
                    ]);
                }
            }
        }
        if($request->type == 1){
            foreach($request->cats as $item){
                $cProduct = Category::where('id' , $item)->first();
                foreach($cProduct->product as $product){
                    if($request->percent){
                        $amount = (int)$product->offPrice + (int)(($product->offPrice * $request->percent) / 100);
                    }elseif($request->number){
                        $amount = (int)$product->offPrice + (int)$request->number;
                    }else{
                        $amount = (int)$product->offPrice;
                    }
                    $product->update([
                        'offPrice' => $amount,
                        'price' => $amount,
                        'off' => '',
                    ]);
                }
            }
        }
        if($request->type == 2){
            foreach($request->products as $products){
                $product = Product::where('id' , $products)->first();
                if($request->percent){
                    $amount = (int)$product->offPrice + (int)(($product->offPrice * $request->percent) / 100);
                }elseif($request->number){
                    $amount = (int)$product->offPrice + (int)$request->number;
                }else{
                    $amount = (int)$product->offPrice;
                }
                $product->update([
                    'offPrice' => $amount,
                    'price' => $amount,
                    'off' => '',
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'تغییرات اعمال شد'
        ]);
    }
    public function decreasePrice(Request $request){
        if($request->type == 0){
            foreach($request->brands as $item){
                $bProduct = Brand::where('id' , $item)->first();
                foreach($bProduct->product as $product){
                    if($request->percent){
                        $amount = (int)$product->offPrice - (int)(($product->offPrice * $request->percent) / 100);
                    }elseif($request->number){
                        $amount = (int)$product->offPrice - (int)$request->number;
                    }else{
                        $amount = (int)$product->offPrice;
                    }
                    $product->update([
                        'offPrice' => $amount,
                        'price' => $amount,
                        'off' => '',
                    ]);
                }
            }
        }
        if($request->type == 1){
            foreach($request->cats as $item){
                $cProduct = Category::where('id' , $item)->first();
                foreach($cProduct->product as $product){
                    if($request->percent){
                        $amount = (int)$product->offPrice - (int)(($product->offPrice * $request->percent) / 100);
                    }elseif($request->number){
                        $amount = (int)$product->offPrice - (int)$request->number;
                    }else{
                        $amount = (int)$product->offPrice;
                    }
                    $product->update([
                        'offPrice' => $amount,
                        'price' => $amount,
                        'off' => '',
                    ]);
                }
            }
        }
        if($request->type == 2){
            foreach($request->products as $products){
                $product = Product::where('id' , $products)->first();
                if($request->percent){
                    $amount = (int)$product->offPrice - (int)(($product->offPrice * $request->percent) / 100);
                }elseif($request->number){
                    $amount = (int)$product->offPrice - (int)$request->number;
                }else{
                    $amount = (int)$product->offPrice;
                }
                $product->update([
                    'offPrice' => $amount,
                    'price' => $amount,
                    'off' => '',
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'تغییرات اعمال شد'
        ]);
    }
}
