<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function rupiah($angka)
    {
        $result = 'Rp. ' . number_format($angka, 0, ',', '.');
        return $result;
    }
}
