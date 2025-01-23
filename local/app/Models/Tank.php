<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'parent_id',
        'product_id',
        'user_id',
        'count',
        'type',
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }
    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }
    public function tanks()
    {
        return $this->belongsTo(Tank::class , 'parent_id' , 'id');
    }
}
