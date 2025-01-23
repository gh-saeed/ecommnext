<?php

namespace App\Imports;

use App\Models\News;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class BlogImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            $post = News::where('title', $row[0])->first();
            if($post){
                $post = News::create([
                    'title' => $row[0],
                    'titleSeo' => $row[0],
                    'keyword' => $row[0],
                    'imageAlt' => $row[0],
                    'slug' => $row[1],
                    'image' => $row[2],
                    'bodySeo' => $row[3],
                    'body' => $row[4],
                ]);
            }
        }
    }
}
