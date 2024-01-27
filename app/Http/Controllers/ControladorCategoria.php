<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Categoria;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller {

      public function nuevo()
    {   
        $titulo = "Nueva Categoría";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CATEGORIAALTA")) {
                $codigo = "CATEGORIAALTA";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                
                $categoria = new Categoria();
                return view('sistema.categoria-nuevo', compact('titulo', 'categoria'));
            }
        }else{
            return redirect('admin/login');
        }
    }

    public function index()
    {
            $titulo = "Listado de Categorías";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CATEGORIACONSULTA")) {
                    $codigo = "CATEGORIACONSULTA";
                    $mensaje = "No tiene pemisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
    
                } else {
                    return view('sistema.categoria-listar', compact('titulo'));
                }
            }else{
                return redirect('admin/login');
            }
    }

    public function guardar(Request $request){
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Categoría";
            $entidad = new Categoria();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $categoria = new Categoria();
                $categoria->obtenerPorId($entidad->idcategoria);
        
                return view('sistema.categoria-nuevo', compact('idcategoria', 'nombre',)) . '?id=' . $entidad->idcategoria;
        
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
                
                $_POST["id"] = $entidad->idcategoria;
                $titulo = "Listado de Categorías";
                return view('sistema.categoria-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Categoria();
        $aCategorias = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/categoria/' . $aCategorias[$i]->idcategoria . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aCategorias[$i]->nombre;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar Categoria";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CATEGORIAEDITAR")) {
                $codigo = "CATEGORIAEDITAR";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $categoria = new Categoria();
                $categoria->obtenerPorId($id);

                return view('sistema.categoria-nuevo', compact( 'titulo', 'categoria'));
            }
        }else{
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        $titulo = "Eliminar Categoria";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CATEGORIAEDITAR")) {
                $codigo = "CATEGORIAEDITAR";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {

                $id = $request->input("id");

                //Si no tiene pedidos asociados, lo elimino
                $producto = new Producto();
                $aProductos = $producto->obtenerPorCategoria($id);

                if(count($aProductos)==0){
                    $categoria = new Categoria();
                    $categoria->idcategoria = $id;
                    $categoria->eliminar();
                    $data["err"] = "OK";

                }else{
                    $data["err"] = "No se puede eliminar la categoria con productos asociados.";
                
                }
                return json_encode($data);
            }
        } else { 
            return redirect('admin/login');
        }

    }


}


?>