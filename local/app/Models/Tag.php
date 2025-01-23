<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'name',
        'nameSeo',
        'bodySeo',
        'slug',
        'type',
        'body',
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
        return $this->morphedByMany(Product::class, 'taggables');
    }
    public function blogs()
    {
        return $this->morphedByMany(News::class, 'taggables');
    }
}
