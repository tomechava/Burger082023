<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorWebLogin extends Controller
{
    public function index()
    {
            return view('web.login');
    }

    public function ingresar(Request $request)
    {
        $correo = $request->input('txtCorreo');
        $clave = $request->input('txtClave');
        $cliente = new Cliente();
        if($cliente->obtenerPorCorreo($correo)){
            if(password_verify($clave, $cliente->clave)){
                Session::put('idcliente', $cliente->idcliente);
                return redirect('/mi-cuenta');
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Credenciales incorrectas. Verifique los datos ingresados.";
            }
        } else {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Credenciales incorrectas. Verifique los datos ingresados.";
        }
        return view('web.login', compact('msg'));
        
    }
}
