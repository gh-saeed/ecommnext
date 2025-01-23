<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Setting;
use App\Traits\SeoHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use SeoHelper;
    public function index()
    {
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $myCart = Cart::where('number',0)->where('user_id', $user_id)->pluck('product_id');
        $cats = Category::whereHas('product', function ($qs) use($myCart) {
            $qs->whereIn('id',$myCart);
        })->take(5)->get();
        $getCart = $this->getCart();
        return view('home.cart.index',compact('cats','getCart'));
    }
    public function next()
    {
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $myCart = Cart::where('number',1)->where('user_id', $user_id)->pluck('product_id');
        $cats = Category::whereHas('product', function ($qs) use($myCart) {
            $qs->whereIn('id',$myCart);
        })->take(5)->get();
        $getCart = $this->getNextCart();
        return view('home.cart.next',compact('cats','getCart'));
    }
    public function checkout()
    {
        $address = auth()->user()->address()->where('status',1)->first();
        $getCart = $this->getCart();
        $zarinpalStatus = Setting::where('key' , 'zarinpalStatus')->pluck('value')->first();
        $zibalStatus = Setting::where('key' , 'zibalStatus')->pluck('value')->first();
        $nextpayStatus = Setting::where('key' , 'nextpayStatus')->pluck('value')->first();
        $idpayStatus = Setting::where('key' , 'idpayStatus')->pluck('value')->first();
        $statusBeh = Setting::where('key' , 'statusBeh')->pluck('value')->first();
        $statusSadad = Setting::where('key' , 'statusSadad')->pluck('value')->first();
        $statusAsan = Setting::where('key' , 'statusAsan')->pluck('value')->first();
        $statusPasargad = Setting::where('key' , 'statusPasargad')->pluck('value')->first();
        $statusSaman = Setting::where('key' , 'statusSaman')->pluck('value')->first();
        $tax = Setting::where('key' , 'tax')->pluck('value')->first();
        return view('home.cart.checkout',compact('getCart','address','tax','zarinpalStatus','zibalStatus','nextpayStatus','idpayStatus','statusBeh','statusSadad','statusAsan','statusPasargad','statusSaman'));
    }
    public function change(Request $request){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $cartsAr = Cart::where('number',0)->where('user_id', $user_id)->get();
        for ( $i = 0; $i < count($cartsAr); $i++) {
            $post = Product::where('id' , $cartsAr[$i]['product_id'])->first();
            if($cartsAr[$i]['color']){
                foreach(json_decode($post['colors']) as $color){
                    if($color->name == $cartsAr[$i]['color']){
                        if($color->count < json_decode($request->count)[$i]){
                            return __('messages.no_product3',['count'=>json_decode($request->count)[$i],'color'=>$cartsAr[$i]['color'],'title'=>$post->title]);
                        }
                    }
                }
            }
            if($cartsAr[$i]['size']){
                foreach(json_decode($post['size']) as $size){
                    if($size->name == $cartsAr[$i]['size']){
                        if($size->count < json_decode($request->count)[$i]){
                            return __('messages.no_product4',['count'=>json_decode($request->count)[$i],'size'=>$cartsAr[$i]['size'],'title'=>$post->title]);
                        }
                    }
                }
            }
            if($post->count < json_decode($request->count)[$i]){
                return __('messages.no_product6',['count'=>json_decode($request->count)[$i],'title'=>$post->title]);
            }
            $cartsAr[$i]->update([
                'count' => json_decode($request->count)[$i],
            ]);
        }
        return $this->getCart();
    }
    public function delete(Request $request){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        Cart::where('id',$request->cart)->where('user_id', $user_id)->delete();
        return $this->getCart();
    }
    public function move(Request $request){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        Cart::where('id',$request->cart)->where('user_id', $user_id)->update([
            'number' => $request->type
        ]);
        if($request->type){
            return $this->getCart();
        }else{
            return $this->getNextCart();
        }
    }
    public function moveAll(Request $request){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        Cart::where('number',1)->where('user_id', $user_id)->update([
            'number' => 0
        ]);
        return redirect('/cart');
    }
    public function addAddress(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'post' => 'required',
            'state' => 'required',
            'city' => 'required',
            'plaque' => 'required',
            'number' => 'required',
        ]);
        auth()->user()->address()->update(array(
            'status' => 0,
        ));
        $address = Address::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'post'=> $request->post,
            'state'=> $request->state1,
            'city'=> $request->city1,
            'plaque'=> $request->plaque,
            'number'=> $request->number,
            'unit'=> $request->unit,
            'status'=> 1,
        ]);
        auth()->user()->address()->attach($address->id);
        return redirect()->back()->with([
            'message' => 'آدرس با موفقیت ثبت شد'
        ]);
    }
    public function addCart(Request $request){
        $product = Product::where('id', $request->product)->first();
        $preBuy = 0;
        $price = $this->getPrices($product,$request->size,$request->color);
        if(!is_int($price)){
            return 'limit';
        }
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $check = Cart::where('product_id', $request->product)->where('size', $request->size)->where('color', $request->color)->where('guarantee_id', $request->guarantee)->where('user_id', $user_id)->first();
        if ($check) {
            if($product['colors']){
                foreach(json_decode($product['colors']) as $item){
                    if($item->name == $request->color){
                        $price = (int)$price + (int)$item->price;
                        if($item->count <= $check->count){
                            return 'limit';
                        }
                    }
                }
            }
            if($product['size']){
                foreach(json_decode($product['size']) as $item){
                    if($item->name == $request->size){
                        $price = (int)$price + (int)$item->price;
                        if($item->count <= $check->count){
                            return 'limit';
                        }
                    }
                }
            }
            if($product->count <= $check->count){
                return 'limit';
            }
            $check->update([
                'count' => ++$check->count,
                'price' => ++$check->count
            ]);
        }
        else {
            if($product->inquiry == 1){
                $inquiry = 0;
            }else{
                $inquiry = 2;
            }
            Cart::create([
                'product_id' => $request->product,
                'user_id' => $user_id,
                'guarantee_id' => $request->guarantee,
                'color' => $request->color,
                'size' => $request->size,
                'inquiry' => $inquiry,
                'price' => $price,
                'count' => 1,
            ]);
        }
        return $this->getCart();
    }

    public function checkDiscount(Request $request){
        $time = Carbon::now()->format('Y-m-d h:i');
        $dis = Discount::where('code' , $request->discount)->where('status' , 1)->where('day', '>=' , $time)->where('count' , '>=' , 1)->first();
        if($dis){
            foreach (auth()->user()->cart as $value) {
                $value->update([
                    'discount' => $dis['code']
                ]);
            }
            $getCart = $this->getCart();
            return $getCart[2] - (($getCart[2]*$dis->percent) / 100);
        }else{
            return 'no';
        }
    }
    public function getCart(){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $myCart = Cart::where('number',0)->where('user_id', $user_id)->get();
        $carts = [];
        $carrierPrices = 0;
        $prices = 0;
        $countCart = 0;
        foreach($myCart as $item) {
            $send = Product::where('id', $item['product_id'])->with('user')->first();
            if(!$send){
                $item->delete();
            }else{
                $carrierPrice = $this->getCarrier($send);
                $getPrices = $this->getPrices($send,$item->size,$item->color);
                if(is_int($getPrices)){
                    $item->update([
                        'carrier_price' => $carrierPrice,
                        'price' => $carrierPrice + $getPrices,
                    ]);
                    $carrierPrices += $carrierPrice;
                    $prices += ($getPrices * $item->count) + $carrierPrice;
                    $data = [
                        'title' => $send->title,
                        'image' => $send->image !='[]'?json_decode($send->image)[0]:'',
                        'slug' => $send->slug,
                        'time' => $send->time,
                        'max' => $send->count,
                        'user_name' => $send->user->name,
                        'user_slug' => $send->user->slug,
                        'carrier_price' => $carrierPrice,
                        'id' => $item['id'],
                        'count' => $item['count'],
                        'size' => $item['size'],
                        'color' => $item['color'],
                        'price' => $carrierPrice + $getPrices,
                        'guarantee_id' => $item['guarantee_id'],
                    ];
                    $countCart += $item->count;
                    array_push($carts, $data);
                }else{
                    $item->delete();
                }
            }
        };
        return [$carts,$carrierPrices,$prices,$countCart];
    }
    public function getNextCart(){
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $myCart = Cart::where('number',1)->where('user_id', $user_id)->get();
        $carts = [];
        $carrierPrices = 0;
        $prices = 0;
        foreach($myCart as $item) {
            $send = Product::where('id', $item['product_id'])->with('user')->first();
            if(!$send){
                $item->delete();
            }else{
                $carrierPrice = $this->getCarrier($send);
                $getPrices = $this->getPrices($send,$item->size,$item->color);
                if(is_int($getPrices)){
                    $item->update([
                        'carrier_price' => $carrierPrice,
                        'price' => $carrierPrice + $getPrices,
                    ]);
                    $carrierPrices += $carrierPrice;
                    $prices += ($getPrices * $item->count) + $carrierPrice;
                    $data = [
                        'title' => $send->title,
                        'image' => $send->image !='[]'?json_decode($send->image)[0]:'',
                        'slug' => $send->slug,
                        'time' => $send->time,
                        'max' => $send->count,
                        'user_name' => $send->user->name,
                        'user_slug' => $send->user->slug,
                        'carrier_price' => $carrierPrice,
                        'id' => $item['id'],
                        'count' => $item['count'],
                        'size' => $item['size'],
                        'color' => $item['color'],
                        'price' => $carrierPrice + $getPrices,
                        'guarantee_id' => $item['guarantee_id'],
                    ];
                    array_push($carts, $data);
                }else{
                    $item->delete();
                }
            }
        };
        return [$carts,$carrierPrices,$prices];
    }
    public function getCarrier($product)
    {
        $user_id = auth()->user()?auth()->user()->id:request()->ip();
        $weights = $product->weight/1000;
        $car = $product->carriers()->first();
        if ($car){
            $allCP = 0;
            foreach (Cart::where('user_id' , $user_id)->where('number' , 0)->get(['product_id','count','price']) as $val){
                $productM = Product::where('id',$val->product_id)->whereHas('carriers', function ($q) use ($car) {
                    $q->where('id', $car->id);
                })->first();
                if($productM){
                    $weights += ($productM['weight'] * $val->count)/1000;
                    $allCP += (($val->price-$val->carrier_price) * $val->count);
                }
            }
            $sends1 = Carrier::where('id' , $car->id)->first();
            if($sends1){
                if($sends1['limit'] <= $allCP + (int)($weights*$sends1['weightPrice'])){
                    return 0;
                }else{
                    return (int)($sends1['price'] + (int)($weights*$sends1['weightPrice']));
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public function getPrices($product,$size2,$color2)
    {
        $price = $product->price;
        if($product['colors'] && $product['colors'] != '[]'){
            $colorExist = 0;
            foreach(json_decode($product['colors']) as $item){
                if($item->name == $color2){
                    $colorExist = 1;
                    $price = (int)$price + (int)$item->price;
                    if($item->count <= 0){
                        return 'limit';
                    }
                }
            }
            if(!$colorExist){
                return 'no';
            }
        }
        if($product['size'] && $product['size'] != '[]'){
            $sizeExist = 0;
            foreach(json_decode($product['size']) as $item){
                if($item->name == $size2){
                    $sizeExist = 1;
                    $price = (int)$price + (int)$item->price;
                    if($item->count <= 0){
                        return 'limit';
                    }
                }
            }
            if(!$sizeExist){
                return 'no';
            }
        }
        if(!$product->user){
            return 'no';
        }
        return (int)$price;
    }
}
