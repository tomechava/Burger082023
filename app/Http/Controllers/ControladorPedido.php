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

}


?>