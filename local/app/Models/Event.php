<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'customer_id',
        'user_id',
        'type',
    ];
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format('H:i Y-n-j');
    }
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class , 'customer_id' , 'id');
    }
}
