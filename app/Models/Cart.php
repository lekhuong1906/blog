<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    public function users(){
        return $this->belongsTo(Cart::class,'id','user_id');
    }

    public function cartDetail(){
        return $this->hasMany(CartDetail::class,'cart_id','id');
    }


}
