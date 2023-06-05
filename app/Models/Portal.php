<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    use HasFactory;

    //-- not required, better to be written to avoid confusion 
    //-- (it specifies which table this model is referring to)
    protected $table = 'portals';

    //-- specifies which arguments need to be filled when creating a new row
    protected $fillable = [
        'name'
    ];

    //-- when getting a model from database, if these atrributes are hidden, 
    //-- then they won't be shown when returning data to user
    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
