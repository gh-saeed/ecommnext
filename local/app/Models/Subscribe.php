<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;
    protected $fillable=[
        'name'
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }
}
