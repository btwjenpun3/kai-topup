<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(Harga::class);
    }

    public function harga()
    {
        return $this->hasMany(Harga::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
