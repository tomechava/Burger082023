<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Producto;
require app_path() . '/start/constants.php';

class ControladorProducto extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Producto";
        return view('sistema.producto-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Productos";
            return view('sistema.producto-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $producto = new Producto();
                $producto->obtenerPorId($entidad->idproducto);
        
                return view('sistema.producto-nuevo', compact('idproducto', 'nombre', 'cantidad', 'precio', 'descripcion', 'imagen', 'fk_idcategoria')) . '?id=' . $entidad->idproducto;
        
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
                
                $_POST["id"] = $entidad->idproducto;
                $titulo = "Listado de Productos";
                return view('sistema.producto-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }

}


?>