<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
            return view('web.mi-cuenta');
    }
}
