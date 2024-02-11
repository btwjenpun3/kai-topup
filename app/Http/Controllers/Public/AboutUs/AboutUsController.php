<?php

namespace App\Http\Controllers\Public\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('pages.public.about-us.index');
    }
}
