<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['token', 'name' ];

    use HasFactory;
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
