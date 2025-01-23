<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'title',
        'body',
        'type',
        'customer_id',
        'file',
        'parent_id',
        'answer',
        'status',
    ];
    public function getCreatedAtAttribute($value)
    {
        $carbonDate = Carbon::parse($value, 'UTC');
        $carbonDate->setTimezone('Asia/Tehran');
        return $carbonDate->format('H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %m / %Y');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'parent_id','id');
    }
}
