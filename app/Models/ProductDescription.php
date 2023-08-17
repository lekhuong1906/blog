<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'introduce',
        'material',
        'size',
        'contain',
        'other',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'id','product_description_id');
    }
}
