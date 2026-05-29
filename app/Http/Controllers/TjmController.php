<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TjmController extends Controller
{
    public function index(): View
    {
        return view('tjm.index');
    }
}
