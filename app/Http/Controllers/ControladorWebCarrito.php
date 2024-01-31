<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
            return view('web.carrito');
    }
}
