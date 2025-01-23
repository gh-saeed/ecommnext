<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genuine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'post', 'code' , 'job', 'landNumber','landlinePhone' , 'gender', 'residenceAddress','user_id'
    ];
}
