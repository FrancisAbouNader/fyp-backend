<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'location',
        'user_id'
    ];

    function productSales()
    {
        return $this->belongsToMany(Product::class, 'company_product_sales')->withPivot('quantity');
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
