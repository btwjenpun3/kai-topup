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

    public function ewallet()
    {
        return $this->belongsTo(XenditEWallet::class, 'xendit_e_wallet_id');
    }

    public function qr()
    {
        return $this->belongsTo(XenditQr::class, 'xendit_qr_id');
    }

    public function va()
    {
        return $this->belongsTo(XenditVa::class, 'xendit_va_id');
    }
}
