<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'title',
        'titleSeo',
        'user_id',
        'time',
        'status',
        'suggest',
        'image',
        'video',
        'imageAlt',
        'keyword',
        'body',
        'bodySeo',
        'slug',
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function category()
    {
        return $this->morphToMany(Category::class, 'catables');
    }
    public function tag()
    {
        return $this->morphToMany(Tag::class, 'taggables');
    }
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
