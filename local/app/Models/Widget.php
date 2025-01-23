<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Widget extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'title',
        'more',
        'description',
        'responsive',
        'background',
        'slug',
        'count',
        'sort',
        'type',
        'status',
        'brands',
        'number',
        'cats',
        'users',
        'ads1',
        'ads2',
        'ads3',
        'user_id',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function ($instance) {
            Cache::forget('product.'.$instance->slug);
            Cache::forget('related.'.$instance->slug);
            Cache::forget('index');
        });

        static::deleting(function ($instance) {
            Cache::forget('product.'.$instance->slug);
            Cache::forget('index');
            Cache::forget('related.'.$instance->slug);
        });
    }
}
