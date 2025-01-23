<?php

namespace App\Imports;

use App\Models\Carrier;
use App\Models\Category;
use App\Models\Post;
use App\Models\PriceChange;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            if(is_integer($row[2])){
                $carrier = Carrier::where('user_id',auth()->id())->where('id',$row[8])->first();
                $category = Category::where('name' , "LIKE" , "%{$row[9]}%")->first();
                $post = Product::where(function ($query) use($row) {
                    $query->where('title', $row[0])
                        ->orWhere('product_id', $row[1]);
                })->first();
                if(!$post && $carrier && $category){
                    if ($row[3]){
                        $price = round((int)$row[2] - ((int)$row[2] * $row[3] / 100));
                    }else{
                        $price = (int)$row[2];
                    }
                    $post = Product::create([
                        'title' => $row[0],
                        'off' => $row[3] >= 1 ? $row[3] : 0,
                        'product_id' => $row[1],
                        'offPrice' => $row[1],
                        'price' => $price,
                        'user_id' => auth()->user()->id,
                        'status' => 0,
                        'weight' => $row[7],
                        'showcase' => 0,
                        'time' => 1,
                        'property' => 1,
                        'used' => 0,
                        'inquiry' => 0,
                        'count' => $row[4],
                        'image' => json_encode(explode(',',$row[5])),
                        'body' => $row[6],
                    ]);
                    PriceChange::create([
                        'price' => $price,
                        'product_id' => $post->id,
                    ]);
                    $post->carriers()->sync($carrier);
                    $post->category()->sync($category);
                }
            }
        }
    }
}
