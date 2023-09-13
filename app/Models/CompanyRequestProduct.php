<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyRequestProduct extends Model
{
    use HasFactory;

    protected $table = 'company_request_products';

    protected $fillable = [
        "company_request_id",
        "product_id",
        "quantity"
    ];

    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function companyRequest()
    {
        return $this->belongsTo(CompanyRequest::class);
    }

    function items()
    {
        return $this->belongsToMany(Item::class, "company_request_product_items");
    }

}
