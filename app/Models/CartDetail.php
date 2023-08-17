<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
     protected $fillable = [
         'cart_id',
         'product_id',
         'quantity',
         'price',
     ];

     public function cart(){
         return $this->belongsTo(Cart::class,'cart_id','id');
     }

     public function product(){
         return $this->hasMany(Product::class,'id','product_id');
     }

}
