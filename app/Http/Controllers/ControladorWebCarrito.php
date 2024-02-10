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
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
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

        $pedido = new Pedido();
        $pedido->fk_idcliente = $idCliente;
        $pedido->fecha = date("Y-m-d H:m:s");
        $pedido->total = $request->input('txtTotal');
        $pedido->comentario = $request->input('txtComentario');
        $pedido->fk_idsucursal = $request->input('lstSucursales');
        $pedido->fk_idestadopedido = 1; //1 = Pendiente de pago
        $pedido->metodo_pago = $request->input('lstMetodoDePago');
        $idPedido = $pedido->insertar();

        if($request->input('lstMetodoDePago') == "sucursal"){
            
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
            $productoCarrito->eliminarPorCarrito($idCarrito);

            return redirect('/pedido?id='.$idPedido);

        }else if($request->input('lstMetodoDePago') == "mercadopago"){
            //$access_token = "TEST-6390311397564415-072818-d4115be4557ceb9d5465f4680d29995a__LB_LA_-70360379";
            $access_token = "TEST-8156422208818000-021012-8a4c15e8c22bd2476e3079d8ab1a7762-1489498448";
            SDK::setClientId(config("payment-methods.mercadopago.client"));
            SDK::setClientSecret(config("payment-methods.mercadopago.secret"));
            SDK::setAccessToken(config($access_token));

            $item = new Item();
            $item->id = "1234";
            $item->title = "BurgerHub";
            $item->category_id = "products";
            $item->quantity = 1;
            $item->unit_price = $request->input('txtTotal');
            $item->currency_id = "COP";

            $preference = new Preference();
            $preference->items = array($item);

            //Datos del comprador
            $payer = new Payer();
            $payer->name = $nombreCliente;
            $payer->surname = $cliente->apellido;
            $payer->email = $cliente->email;
            $payer->date_created = date("Y-m-d H:m:s");
            $payer->identification = array(
                "type" => "DNI",
                "number" => $cliente->dni,
            );
            $preference->payer = $payer;

            //URL de configuracion para indicarle a MercadoPago donde redirigir al usuario
            $preference->back_urls = [
                "success" => "http://127.0.0.1:8000/mercado-pago/aprobado/". $idPedido,
                "pending" => "http://127.0.0.1:8000/mercado-pago/pendiente/". $idPedido,
                "failure" => "http://127.0.0.1:8000/mercado-pago/error/". $idPedido
            ];

            $preference->payment_methods = array("installments" => 6);
            $preference->auto_return = "all";
            $preference->notification_url = '';
            $preference->save(); //Ejecuta la transaccion
        }


        

    }

    public function aprobarCompra($idPedido){
        $pedido = new Pedido();
        $pedido->aprobar($idPedido);
        return redirect('/pedido?id='.$idPedido);
    }

    public function rechazarCompra($idPedido){
        $pedido = new Pedido();
        $pedido->rechazar($idPedido);
        return redirect('/pedido?id='.$idPedido);
    }
}
