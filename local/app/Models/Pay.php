<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    protected $fillable=[
        'auth',
        'refId',
        'user_id',
        'price',
        'discount_off',
        'deliver',
        'carrier_price',
        'back',
        'pin',
        'gate',
        'tax',
        'property',
        'method',
        'status',
    ];

    public function scopeBuildCode($query){
        do{
            $code = rand(1111111,9999999);
            $check = Pay::where('property',$code)->first();
        }while($check);
        return $code;
    }

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %B / %Y');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->morphToMany(Address::class, 'addressables');
    }
    public function carrier()
    {
        return $this->morphToMany(Carrier::class, 'carriables');
    }
    public function payMeta()
    {
        return $this->hasMany(PayMeta::class);
    }
    public function myPayMeta()
    {
        return $this->hasMany(PayMeta::class , 'pay_id' , 'id')->whereIn('product_id',Product::where('user_id',auth()->user()->id)->pluck('id'));
    }
}
