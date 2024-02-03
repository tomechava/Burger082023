<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Carrito;
use App\Entidades\Sistema\ProductoCarrito;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller
{
    public function index()
    {   
        $idCliente = Session::get('idcliente');
        $carrito = new Carrito();
        
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        
        $productoCarrito = new ProductoCarrito();
        $productos = array();
        foreach($aCarritos as $carrito){
            $productos = $productoCarrito->obtenerPorCarrito($carrito->idcarrito);
        }

        return view('web.carrito', compact('productos'));
    }
}
