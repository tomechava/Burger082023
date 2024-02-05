<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Carrito;
use App\Entidades\Sistema\ProductoCarrito;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebTakeaway extends Controller
{
    public function index()
    {   
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        return view('web.takeaway', compact('aProductos'));
    }

    public function agregar(Request $request)
    {   
        if(Session::get('idcliente')>0){
            $idProducto = $request->input('txtIdProducto');
            $cantidad = $request->input('txtCantidad');

            $idCliente = Session::get('idcliente'); //obtengo el id del cliente logueado

            $carrito = new Carrito();
            $carrito->obtenerPorCliente($idCliente); //obtengo el carrito del cliente logueado

            $productoCarrito = new ProductoCarrito();
            if($productoCarrito->verificarProductoEnCarrito($carrito->idcarrito, $idProducto)) //verifico si el producto ya esta en el carrito
            {
                $productoCarrito->sumarCantidad($carrito->idcarrito,  $cantidad, $idProducto); //actualizo la cantidad del producto en el carrito
            }else{
                $productoCarrito->agregarAlCarrito($carrito->idcarrito, $idProducto, $cantidad); //agrego el producto al carrito
            }

            $msg["ESTADO"] = "success";
            $msg["MSG"] = "Producto agregado al carrito";

            $producto = new Producto();
            $aProductos = $producto->obtenerTodos();
            return view('web.takeaway', compact('msg', 'aProductos')); //envio mensaje de exito y redirijo a la vista de takeaway
        }else{
            return redirect('/login');
        }
    }

}
