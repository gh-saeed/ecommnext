<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable=[
        'price','status','user_id','refId','property','status','type'
    ];

    public function scopeBuildCode($query){
        do{
            $code = rand(1111111,9999999);
            $check = Wallet::where('property',$code)->first();
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
}
