<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Type extends Model
{
    use HasFactory;
    protected $table = 'types';
    protected $fillable = [
        'type_name',
        'type_description'
    ];

    /*public function product(){
        return $this->belongsTo(Product::class,'product_type','id');
    }*/
}
