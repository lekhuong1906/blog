<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'receipt_id',
        'product_id',
        'quantity',
        'total'
    ];

    public function receipt(){
        return $this->belongsTo(Receipt::class,'id','receipt_id');
    }
}
