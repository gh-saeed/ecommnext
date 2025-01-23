<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'user_ip',
        'type',
        'charge',
        'price',
        'status',
        'pay_id',
        'property',
        'card',
        'shaba',
        'name'
    ];
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %m / %Y');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function scopeBuildCode($query){
        do{
            $code = rand(1111111,9999999);
            $check = Checkout::where('property',$code)->first();
        }while($check);
        return $code;
    }
}
