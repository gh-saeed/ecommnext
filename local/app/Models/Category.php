<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'name',
        'nameSeo',
        'percent',
        'bodySeo',
        'slug',
        'body',
        'type',
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
        return $this->morphedByMany(Product::class, 'catables');
    }
    public function blogs()
    {
        return $this->morphedByMany(News::class, 'catables');
    }
    public function cats()
    {
        return $this->morphedByMany(Category::class, 'catables');
    }
    public function mother()
    {
        return $this->morphToMany(Category::class, 'catables');
    }
    public function brands()
    {
        return $this->morphedByMany(Brand::class, 'catables');
    }
}
