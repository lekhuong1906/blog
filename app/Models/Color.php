<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Color extends Model
{
    use HasFactory;
    protected $table = 'colors';
    protected $fillable = [
        'color_name',
        'color_code',
        'color_description'
    ];

    public function product(){
        return $this->belongsToMany(Product::class,'product_color');
    }
}
