<?php

namespace App\Imports;

use App\Models\PriceChange;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ChangePrice implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            if(is_integer($row[1])){
                $post = Product::where(function ($query) use($row) {
                    $query->where('title', $row[0])
                        ->orWhere('product_id', $row[0]);
                })->first();
                if($post){
                    $post->update([
                        'price' => $row[1],
                        'offPrice' => $row[1],
                    ]);
                }
            }
        }
    }
}
