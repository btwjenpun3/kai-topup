<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function harga()
    {
        return $this->belongsTo(Harga::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
