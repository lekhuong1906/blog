<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    use HasFactory;
    protected $table = 'image_products';
    protected $fillable =[
        'product_id',
        'image_product_name',
        'image',
        'image_product_description'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
