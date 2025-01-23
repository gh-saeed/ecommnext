<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $currencies = Currency::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id','price'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $currencies = Currency::select(['name' , 'id','price'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.currency' , compact('currencies','title'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'price' => 'required|max:10',
        ]);
        $post = Currency::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        return redirect()->back()->with([
            'message' => 'ارز با موفقیت اضافه شد'
        ]);
    }
    public function edit(Currency $currency){
        return $currency;
    }
    public function update(Currency $currency , Request $request){
        $request->validate([
            'name' => 'required|max:220',
            'price' => 'required|max:10',
        ]);
        $currency->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        $products = Product::where('currency_id' , $currency->id)->get();
        foreach ($products as $item){
            $currency1 = $request->price * $item->priceCurrency;
            if ($item->off){
                $price = round((int)$currency1 - ((int)$currency1 * $item->off / 100));
            }else{
                $price = (int)$currency1;
            }
            $post = $item->update([
                'price' => $price,
                'offPrice' => $currency1,
            ]);
        }
        return redirect()->back()->with([
            'message' => 'ارز ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Currency $currency){
        $currency->delete();
        return redirect()->back()->with([
            'message' => 'ارز با موفقیت حذف شد'
        ]);
    }
}
