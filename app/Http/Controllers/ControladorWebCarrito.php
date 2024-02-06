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
        if(Session::get('idcliente')>0){ //verifico si el cliente esta logueado
        $idCliente = Session::get('idcliente');
        $carrito = new Carrito();
        
        $carrito->obtenerPorCliente($idCliente);
        
        $productoCarrito = new ProductoCarrito();
        $productos = array();
        $productos = $productoCarrito->obtenerPorCarrito($carrito->idcarrito);
        

        return view('web.carrito', compact('productos'));
        }else{
            return redirect('/login');
        }
    }

    public function eliminar()
    {   
        $idCliente = Session::get('idcliente');
        $idProducto = $_GET["id"];

        $carrito = new Carrito();
        $carrito->obtenerPorCliente($idCliente);
        $idCarrito = $carrito->idcarrito;

        $productoCarrito = new ProductoCarrito();
        $productoCarrito->eliminarProducto($idCarrito, $idProducto);
        return redirect('/carrito');
    }
}
