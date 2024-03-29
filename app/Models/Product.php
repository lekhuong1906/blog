<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable = [
        'product_name',
        'product_type',
        'product_price',
        'product_stock',
        'status',
    ];
    public function type(){
        return $this->belongsTo(Type::class,'product_type','id');
    }

    public function productDescription(){
        return $this->hasOne(ProductDescription::class,'id','product_id');
    }

    public function imageProduct(){
        return $this->hasMany(ImageProduct::class,'id','product_id');
    }

    public function cartDetail(){
        return $this->belongsTo(CartDetail::class,'product_id','id');
    }
}
