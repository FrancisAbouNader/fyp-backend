<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Brand;
use App\Models\Section;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'model_number',
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

    function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    function items()
    {
        return $this->hasMany(Item::class);
    }

    function companySales()
    {
        return $this->belongsToMany(Company::class, 'company_product_sales')->withPivot('quantity');
    }

    function sections()
    {
        return $this->hasMany(Section::class);
    }
}
