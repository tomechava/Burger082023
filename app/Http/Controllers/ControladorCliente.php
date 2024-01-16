<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Cliente";
        return view('sistema.cliente-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Clientes";
            return view('sistema.cliente-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new Cliente();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $cliente = new Cliente();
                $cliente->obtenerPorId($entidad->idcliente);
        
                return view('sistema.cliente-nuevo', compact('idcliente', 'nombre', 'apellido', 'correo', 'telefono', 'dni', 'clave')) . '?id=' . $entidad->idcliente;
        
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
                
                $_POST["id"] = $entidad->idcliente;
                $titulo = "Listado de Clientes";
                return view('sistema.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }
    


}


?>