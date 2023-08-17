<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRequest extends Model
{
    use HasFactory;

    protected $table = 'company_requests';

    protected $fillable = [
        "company_to_id",
        "company_from_id",
        "request_status_id"
    ];

    function products()
    {
        return $this->belongsToMany(Product::class, "user_request_products");
    }

    function companyTo()
    {
        return $this->belongsTo(Company::class, "company_to_id");
    }

    function companyFrom()
    {
        return $this->belongsTo(Company::class, "company_from_id");
    }
}
