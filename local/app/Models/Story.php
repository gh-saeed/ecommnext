<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'image',
        'cover',
        'type',
        'user_id',
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %B / %Y');
    }
    public function getUpdatedAtAttribute($value)
    {
        return verta($value)->formatDifference();
    }
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
