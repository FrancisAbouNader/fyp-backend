<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        "address_line",
        "second_address_line",
        "city",
        "country",
        "model_type",
        "model_id"
    ];

    public function modeleable()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id'); 
    }
}
