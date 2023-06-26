<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\Color;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable = [
        'product_name',
        'product_type',
        'product_color',
        'product_description',
        'product_price',
        'product_stock'
    ];
    /*public function type(){
        return $this->hasOne(Product::class,'product_type','id');
    }
    public function color(){
        return $this->belongsTo(Product::class,'product_color','id');
    }*/
}
