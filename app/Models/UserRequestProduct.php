<?php

namespace App\Models;

use App\Models\UserRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRequestProduct extends Model
{
    use HasFactory;

    protected $table = 'user_request_products';

    protected $fillable = [
        "user_request_id",
        "product_id",
        "quantity"
    ];

    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function userRequest()
    {
        return $this->belongsTo(UserRequest::class);
    }

    function items()
    {
        return $this->belongsToMany(Item::class, "user_request_product_items")
    }
}
