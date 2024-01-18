<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\EstadoSucursal;
require app_path() . '/start/constants.php';

class ControladorEstadoSucursal extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Estado de Sucursal";
        return view('sistema.estado_sucursal-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Estados de Sucursales";
            return view('sistema.estado_sucursal-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Estado de Sucursal";
            $entidad = new EstadoSucursal();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $estadoSucursal = new Producto();
                $estadoSucursal->obtenerPorId($entidad->idestadosucursal);
        
                return view('sistema.estado_sucursal-nuevo', compact('idestadosucursal', 'nombre',)) . '?id=' . $entidad->idestadosucursal;
        
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
                
                $_POST["id"] = $entidad->idestadosucursal;
                $titulo = "Listado de Estados de Sucursales";
                return view('sistema.estado_sucursal-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }


}


?>