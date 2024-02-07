<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Pedido;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {       
        if(Session::get('idcliente')!= ""){
            $id = Session::get('idcliente');
            $cliente = new Cliente();
            $cliente->obtenerPorId($id);

            $pedido = new Pedido();
            $pedidos = $pedido->obtenerPorCliente($id);

            return view('web.mi-cuenta', compact('cliente', 'pedidos'));
        } else {
            return redirect('/login');
        }
    }

    public function guardar(Request $request)
    {
        if(trim($request->input('txtNombre')) != "" 
        && trim($request->input('txtApellido')) != "" 
        && trim($request->input('txtCorreo')) != "" 
        && trim($request->input('txtTelefono')) != ""){

            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get('idcliente'));
            $cliente->nombre = $request->input('txtNombre');
            $cliente->apellido = $request->input('txtApellido');
            $cliente->correo = $request->input('txtCorreo');
            $cliente->telefono = $request->input('txtTelefono');
            $cliente->guardar();

            $pedido = new Pedido();
            $pedidos = $pedido->obtenerPorCliente($cliente->idcliente);

            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = "Datos guardados correctamente";
            return view('web.mi-cuenta', compact('msg', 'cliente', 'pedidos'));
        } else {
            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get('idcliente'));

            $pedido = new Pedido();
            $pedidos = $pedido->obtenerPorCliente($cliente->idcliente);

            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los campos";

            return view('web.mi-cuenta', compact('msg', 'cliente', 'pedidos'));
        }
    }
}
