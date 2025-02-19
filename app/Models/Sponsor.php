<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('exp_date');
    }
    protected $fillable = [
        'tier',
        'hours',
        'price'
    ];
}
