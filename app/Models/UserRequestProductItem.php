<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRequestProductItem extends Model
{
    use HasFactory;

    protected $table = 'user_request_product_items';

    protected $fillable = [
        "user_request_product_id",
        "item_id"
    ];

    function item()
    {
        return $this->belongsTo(Item::class);
    }

    function userRequestProduct()
    {
        return $this->belongsTo(UserRequestProduct::class);
    }
}
