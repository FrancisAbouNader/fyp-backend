<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRequestProductItem extends Model
{
    use HasFactory;

    protected $table = 'company_request_product_items';

    protected $fillable = [
        "company_request_product_id",
        "item_id"
    ];

    function companyRequestProduct()
    {
        return $this->belongsTo(companyRequestProduct::class);
    }

    function item()
    {
        return $this->belongsTo(Item::class);
    }
}
