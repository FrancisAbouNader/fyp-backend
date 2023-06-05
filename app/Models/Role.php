<?php

namespace App\Models;

use App\Models\Portal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = ['name', 'portal_id', 'guard_name'];


    public function portal()
    {
        return $this->belongsTo(Portal::class);
    }

}
