<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','slug','type','number','parent_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }
    public function children()
    {
        return $this->hasMany(Link::class , 'parent_id' , 'id');
    }
}
