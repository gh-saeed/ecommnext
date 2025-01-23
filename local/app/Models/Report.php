<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable=[
        'data',
        'user_id',
        'status',
        'reportable_id',
        'reportable_type',
    ];
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %B / %Y');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'reportable_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'reportable_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
