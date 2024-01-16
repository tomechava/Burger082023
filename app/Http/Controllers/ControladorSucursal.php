<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Sucursal;
require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller {

      public function nuevo()
    {
        $titulo = "Nueva Sucursal";
        return view('sistema.sucursal-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Sucursales";
            return view('sistema.sucursal-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Sucursal";
            $entidad = new Sucursal();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $sucursal = new Producto();
                $sucursal->obtenerPorId($entidad->idsucursal);
        
                return view('sistema.sucursal-nuevo', compact('idsucursal', 'nombre', 'direccion', 'telefono', 'mapa', 'fk_idestadosucursal')) . '?id=' . $entidad->idsucursal;
        
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
                
                $_POST["id"] = $entidad->idsucursal;
                $titulo = "Listado de Sucursales";
                return view('sistema.sucursal-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }

}


?>