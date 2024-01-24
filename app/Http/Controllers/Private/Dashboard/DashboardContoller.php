<?php

namespace App\Http\Controllers\Private\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardContoller extends Controller
{
    public function index()
    {
        return view('pages.private.dashboard.index');
    }
}
