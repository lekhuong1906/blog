<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\Color;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable = [
        'product_name',
        'product_type',
        'product_description',
        'product_price',
        'product_stock'
    ];
    public function type(){
        return $this->belongsTo(Type::class,'product_type','id');
    }
    public function color(){
        return $this->belongsToMany(Color::class,'product_colors');
    }

    public function scopeGetColorProduct(){
        $data = [];
        $allProduct = Product::all();
        foreach ($allProduct as $product){
            $color = DB::table('product_colors')->where('id',$product->id)->get();
        }
         return $data;
    }
}
