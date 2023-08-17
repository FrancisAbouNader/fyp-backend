<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_requests';

    protected $fillable = [
        "user_id",
        "company_id",
        "request_status_id"
    ];

    function products()
    {
        return $this->belongsToMany(Product::class, "user_request_products");
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
