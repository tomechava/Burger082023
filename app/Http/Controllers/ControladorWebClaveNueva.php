<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorWebClaveNueva extends Controller
{
      public function index()
      {
            return view('web.clave-nueva');
      }

}
