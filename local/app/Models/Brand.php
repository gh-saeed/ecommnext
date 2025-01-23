<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'name',
        'slug',
        'body',
        'nameSeo',
        'body',
        'bodySeo',
        'image',
        'keyword',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function product()
    {
        return $this->morphedByMany(Product::class, 'brandables');
    }
}
