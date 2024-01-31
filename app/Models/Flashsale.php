<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashsale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function harga()
    {
        return $this->belongsTo(Harga::class);
    }
}
