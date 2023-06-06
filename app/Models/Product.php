<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','modelNumber',
        'package_height',
        'package_width',
        'package_length',
        'package_weight',
        'product_height',
        'product_width',
        'product_length',
        'product_weight',
        'description',
        "brand_id",
        "product_type_id",
    ];
}
