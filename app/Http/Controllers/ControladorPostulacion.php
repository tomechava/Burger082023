<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Postulacion;
require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller {

      public function nuevo()
    {
        $titulo = "Nueva postulacion";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEALTA")) {
                $codigo = "POSTULANTEALTA";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $postulacion = new Postulacion();
                return view('sistema.postulacion-nuevo', compact('titulo', 'postulacion'));
            }
        }else{
            return redirect('admin/login');
        }

    }

    public function index()
    {
            $titulo = "Listado de postulaciones";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTECONSULTA")) {
                    $codigo = "POSTULANTECONSULTA";
                    $mensaje = "No tiene pemisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
    
                } else {
                    return view('sistema.postulacion-listar', compact('titulo'));
                }
            }else{
                return redirect('admin/login');
            }
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

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Postulacion();
        $aPostulaciones = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/postulacion/' . $aPostulaciones[$i]->idpostulacion . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aPostulaciones[$i]->nombre;
            $row[] = $aPostulaciones[$i]->apellido;
            $row[] = $aPostulaciones[$i]->telefono;
            $row[] = $aPostulaciones[$i]->correo;
            $row[] = $aPostulaciones[$i]->curriculum;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar Postulacion";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEEDITAR")) {
                $codigo = "POSTULANTEEDITAR";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $postulacion = new Postulacion();
                $postulacion->obtenerPorId($id);

                return view('sistema.postulacion-nuevo', compact( 'titulo', 'postulacion'));
            }
        } else { 
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        $titulo = "Eliminar postulacion";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEBAJA")) {
                $codigo = "POSTULANTEBAJA";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $id = $request->input("id");
                
                $postulacion = new Postulacion();
                $postulacion->idpostulacion = $id;
                $postulacion->eliminar();
                $data["err"] = "OK";
                
                return json_encode($data);
            }
        } else { 
            return redirect('admin/login');
        }

    }

}


?>