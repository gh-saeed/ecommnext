<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable=[
        'address',
        'post',
        'name',
        'status',
        'state',
        'show',
        'city',
        'plaque',
        'unit',
        'number',
    ];
    public function user()
    {
        return $this->morphToMany(User::class, 'addressables');
    }
}
