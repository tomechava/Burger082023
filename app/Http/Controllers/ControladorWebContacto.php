<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebContacto extends Controller
{
    public function index()
    {
            return view('web.contacto');
    }
}
