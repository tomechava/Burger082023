<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Producto;
require app_path() . '/start/constants.php';

class ControladorProducto extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Producto";
        $producto = new Producto();
        return view('sistema.producto-nuevo', compact('titulo', 'producto'));

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

            if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                $nombre = date("Ymdhmsi") . "." . $extension;
                $archivo = $_FILES["archivo"]["tmp_name"];
                move_uploaded_file($archivo, env('APP_PATH') . "/public/files/" . $nombre);
                $entidad->imagen = $nombre;
            }

            //validaciones
            if ($entidad->nombre == "") {   //Si falta completar algun campo
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";

                $producto = new Producto();
                $producto->obtenerPorId($entidad->idproducto);
        
                return view('sistema.producto-nuevo', compact('idproducto', 'nombre', 'cantidad', 'precio', 'descripcion', 'imagen', 'fk_idcategoria')) . '?id=' . $entidad->idproducto;
                
            } else {
                if ($_POST["id"] > 0) {

                    $productoAnterior = new Producto();
                    $productoAnterior->obtenerPorId($entidad->idproducto);

                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        if($productoAnterior->imagen != ""){
                            unlink(env('APP_PATH') . "/public/files/" . $productoAnterior->imagen);
                        }
                    } else {
                        $entidad->imagen = $productoAnterior->imagen;
                    }

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

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Producto();
        $aProductos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/producto/' . $aProductos[$i]->idproducto . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aProductos[$i]->nombre;
            $row[] = $aProductos[$i]->nombreCategoria;
            $row[] = '$' . number_format($aProductos[$i]->precio, 2, ",", ".");
            $row[] = '<img src="'. env('APP_PATH') . '/public/files/' . $aProductos[$i]->imagen . '" alt="Imagen del producto" class="img-thumbnail">';
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar Producto";
        $producto = new Producto();
        $producto->obtenerPorId($id);

        return view('sistema.producto-nuevo', compact( 'titulo', 'producto'));
    }

}


?>