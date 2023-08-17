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
        "model_type",
        "model_id"
    ];

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id'); 
    }
}
