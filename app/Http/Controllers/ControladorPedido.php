<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Pedido;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Sucursal;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\EstadoPedido;
use App\Entidades\Sistema\ProductoPedido;
require app_path() . '/start/constants.php';

class ControladorPedido extends Controller {

      public function index()
    {
            $titulo = "Listado de Pedidos";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("PEDIDOCONSULTA")) {
                    $codigo = "PEDIDOCONSULTA";
                    $mensaje = "No tiene pemisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
    
                } else {
                    return view('sistema.pedido-listar', compact('titulo'));
                }
            }else{
                return redirect('admin/login');
            }
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $pedido = new Producto();
                $pedido->obtenerPorId($entidad->idpedido);
        
                return view('sistema.pedido-editar', compact('idpedido', 'fecha', 'total', 'fk_idcliente', 'fk_idsucursal', 'fk_idestadopedido', 'metodo_pago')) . '?id=' . $entidad->idpedido;
        
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                
                $_POST["id"] = $entidad->idpedido;
                $titulo = "Listado de Pedidos";
                return view('sistema.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedido/' . $aPedidos[$i]->idpedido . '" class="btn btn-secondary">Ver</a>';
            $row[] = $aPedidos[$i]->idpedido;
            $row[] = $aPedidos[$i]->nombreCliente;
            $row[] = $aPedidos[$i]->telefonoCliente;
            $row[] = $aPedidos[$i]->fecha;
            $row[] = $aPedidos[$i]->nombreSucursal;
            $row[] = '$' . number_format($aPedidos[$i]->total, 2, ",", ".");
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Editar Pedido";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOEDITAR")) {
                $codigo = "PEDIDOEDITAR	";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $metodos_pago = ["Efectivo", "Transferencia", "Bono"];
                $pedido = new Pedido();
                $pedido->obtenerPorId($id);

                $cliente = new Cliente();
                $cliente->obtenerPorId($pedido->fk_idcliente);
                $pedido->nombreCliente = $cliente->nombre;

                $sucursal = new Sucursal();
                $sucursal->obtenerPorId($pedido->fk_idsucursal);
                $pedido->nombreSucursal = $sucursal->nombre;

                $estadoPedido = new EstadoPedido();
                $aEstados = $estadoPedido->obtenerTodos();

                $productoPedido = new ProductoPedido();
                $aProductosPedido = $productoPedido->obtenerPorPedido($id);

                return view('sistema.pedido-editar', compact( 'titulo', 'pedido', 'aEstados', 'aProductosPedido', 'metodos_pago', 'cliente', 'sucursal'));
    
            }
        } else { 
            return redirect('admin/login');
        }
    }


}


?>