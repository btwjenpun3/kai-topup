<?php

namespace App\Http\Controllers\Private\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('pages.private.log.index');
    }
}
