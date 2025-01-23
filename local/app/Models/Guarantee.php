<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'language',
    ];
    public function product()
    {
        return $this->morphedByMany(Product::class, 'guarantables');
    }
}
