<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'location',
    ];

    function productSales()
    {
        return $this->belongsToMany(Product::class, 'company_product_sales')->withPivot('quantity');
    }
}
