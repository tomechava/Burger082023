<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Pedido;
require app_path() . '/start/constants.php';

class ControladorPedido extends Controller {

      public function index()
    {
            $titulo = "Listado de Pedidos";
            return view('sistema.pedido-listar', compact('titulo'));
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
        
                return view('sistema.pedido-nuevo', compact('idpedido', 'fecha', 'total', 'fk_idcliente', 'fk_idsucursal', 'fk_idestadopedido', 'metodo_pago')) . '?id=' . $entidad->idpedido;
        
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
            $row[] = '<a href="/admin/pedido/' . $aPedidos[$i]->idpedido . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aPedidos[$i]->idpedido;
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

}


?>