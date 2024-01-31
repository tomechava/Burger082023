<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
            return view('web.takeaway');
    }
}
