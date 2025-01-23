<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;
    protected $fillable=[
        'link',
        'status',
        'type',
        'user_id',
        'link_page',
        'link_paginate',
        'page',
    ];
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %B / %Y');
    }
}
