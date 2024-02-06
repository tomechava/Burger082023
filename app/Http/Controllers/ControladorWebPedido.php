<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Pedido;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebPedido extends Controller
{
    public function index()
    {       
            if(Session::get('idcliente') > 0){  // Si el usuario está logueado
                  $pedido = new Pedido();
                  $aPedidos = $pedido->obtenerPorCliente(Session::get('idcliente'));
                  foreach($aPedidos as $pedido){
                        if($pedido->idpedido == $_GET['id']){  // Si el pedido es el que se quiere ver
                              $entidadPedido = new Pedido();
                              $entidadPedido->obtenerPorId($pedido->idpedido);

                              $aProductos = $entidadPedido->obtenerProductos($pedido->idpedido);
                              return view('web.pedido', compact('pedido', 'aProductos'));
                        } else {
                              return redirect('/login');
                        }
                  }
            } else {
                  return redirect('/login');
            }

      }     

}
