<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
