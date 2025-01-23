<?php

namespace App\Imports;

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            $post = User::where('name', $row[0])->first();
            if($post){
                $post = User::create([
                    'name' => $row[0],
                    'number' => $row[1],
                    'email' => $row[2],
                    'profile' => $row[3],
                ]);
            }
        }
    }
}
