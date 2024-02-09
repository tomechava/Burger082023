<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Carrito;
use App\Entidades\Sistema\ProductoCarrito;
use App\Entidades\Sistema\Pedido;
use App\Entidades\Sistema\Sucursal;
use App\Entidades\Sistema\ProductoPedido;
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
        
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view('web.carrito', compact('productos', 'aSucursales'));
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

    public function confirmarCompra(Request $request){
        $idCliente = Session::get('idcliente');
        $cliente = new Cliente();
        $cliente->obtenerPorId($idCliente);
        $nombreCliente = $cliente->nombre;

        $carrito = new Carrito();
        $carrito->obtenerPorCliente($idCliente);
        $idCarrito = $carrito->idcarrito;

        $productoCarrito = new ProductoCarrito();
        $aProductos = array();
        $aProductos = $productoCarrito->obtenerPorCarrito($idCarrito);

        

        if($request->input('lstMetodoDePago') == "sucursal"){
            $pedido = new Pedido();
            $pedido->fk_idcliente = $idCliente;
            $pedido->fecha = date("Y-m-d H:i:s");
            $pedido->total = $request->input('txtTotal');
            $pedido->comentario = $request->input('txtComentario');
            $pedido->fk_idsucursal = $request->input('lstSucursales');
            $pedido->fk_idestadopedido = 2; //2 es el id del estado "pendiente de retiro"
            $pedido->metodo_pago = "Pago en sucursal";
            $idPedido = $pedido->insertar();
            foreach($aProductos as $producto){
                $productoPedido = new ProductoPedido();
                $productoPedido->fk_idproducto = $producto->fk_idproducto;
                $productoPedido->fk_idpedido = $idPedido;
                $productoPedido->precio_unitario = $producto->precio;
                $productoPedido->cantidad = $producto->cantidad;
                $productoPedido->total = $producto->precio * $producto->cantidad;
                $productoPedido->insertar();
            }
            
            //Vaciar el carrito
            $carrito->vaciarPorCliente($idCliente);
            $productoCarrito->vaciarPorCarrito($idCarrito);

            return redirect('/pedido?id='.$idPedido);

        }else{
            $pedido->fk_idestadopedido = 1; //1 es el id del estado "pendiente de pago"
            $pedido->metodo_pago = "MercadoPago";
        }


        

    }
}
