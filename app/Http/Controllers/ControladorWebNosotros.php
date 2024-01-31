<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebNosotros extends Controller
{
    public function index()
    {
            return view('web.nosotros');
    }
}
