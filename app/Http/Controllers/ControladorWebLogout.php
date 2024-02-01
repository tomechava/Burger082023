<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorWebLogout extends Controller
{
      public function salir()
      {
            Session::put('idcliente', "");
            return redirect("/");
      }

}
