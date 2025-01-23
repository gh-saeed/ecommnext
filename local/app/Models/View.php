<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_ip',
        'user_id',
        'browser',
        'viewable_id',
        'viewable_type',
        'platform',
    ];
    public function viewable()
    {
        return $this->morphTo();
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
