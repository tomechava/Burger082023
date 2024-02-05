<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
            return view('web.registrarse');
    }

    public function registrarse(Request $request)
    {
        try {
            $cliente = new Cliente();
            $cliente->cargarDesdeRequest($request);
            $cliente->insertar();

            $this->generarCarrito($cliente->idcliente);

            $msg["ESTADO"] = "success";
            $msg["MSG"] = "Se ha registrado correctamente";
            return view('web.registrarse', compact('msg'));
            
        } catch (Exception $e) {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Error al registrar el cliente";
            $request->session()->put("msg", $msg);
            return view('web.registrarse', compact('msg'));
        }
    }

    private function generarCarrito($idCliente)
    {
        $carrito = new Carrito();
        $carrito->fk_idcliente = $idCliente;
        $carrito->insertar();
    }
}
