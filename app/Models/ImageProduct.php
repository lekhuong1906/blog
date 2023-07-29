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
        'image_name',
        'image_link',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
