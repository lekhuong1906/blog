<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSummary extends Model
{
    use HasFactory;
    protected $fillable = [
        'revenue',
        'total_order',
        'total_receipt',
    ];
}
