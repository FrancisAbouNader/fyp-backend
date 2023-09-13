<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'imei',
        'product_id',
        'ownerable_id',
        'is_sold',
        'ownerable_type' 
    ];

    public function ownerable()
    {
        return $this->morphTo(__FUNCTION__, 'ownerable_type', 'ownerable_id'); 
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
