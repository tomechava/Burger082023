<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorWebRecuperarClave extends Controller
{
      public function index()
      {
            return view('web.recuperar-clave');
      }

      public function recuperar(Request $request)
      {
            $correo = $request->input('txtCorreo');
            $cliente = new Cliente();
            if($cliente->obtenerPorCorreo($correo)){

                  $claveNueva = "";
                  $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                  $longitudClave = rand(8, 12);
                  for($i=0; $i<$longitudClave; $i++){
                        $claveNueva .= substr($str, rand(0, 62), 1);
                  }

                  if($cliente->recuperarClave($correo, password_hash($claveNueva, PASSWORD_DEFAULT))){

                        return view('web.clave-nueva', compact('claveNueva'));
                  } else {
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Ha ocurrido un error al intentar recuperar la contraseña. Intente nuevamente.";
                  }
            } else {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = "El correo ingresado no se encuentra registrado.";
            }
            return view('web.recuperar-clave', compact('msg'));
      }

}
