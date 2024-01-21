<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Postulacion;
require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller {

      public function nuevo()
    {
        $titulo = "Nueva postulacion";
        return view('sistema.postulacion-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de postulaciones";
            return view('sistema.postulacion-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar postulacion";
            $entidad = new Postulacion();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $sucursal = new Producto();
                $sucursal->obtenerPorId($entidad->idsucursal);
        
                return view('sistema.postulacion-nuevo', compact('idpostulacion', 'nombre', 'apellido', 'telefono', 'direccion', 'correo', 'curriculum')) . '?id=' . $entidad->idpostulacion;
        
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
                
                $_POST["id"] = $entidad->idpostulacion;
                $titulo = "Listado de postulaciones";
                return view('sistema.postulacion-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }

}


?>