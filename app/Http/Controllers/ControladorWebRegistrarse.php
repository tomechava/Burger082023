<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
            return view('web.registrarse');
    }
}
