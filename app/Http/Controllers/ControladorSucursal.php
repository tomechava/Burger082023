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

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Sucursal();
        $aSucursales = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aSucursales) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sucursal/' . $aSucursales[$i]->idsucursal . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aSucursales[$i]->nombre;
            $row[] = $aSucursales[$i]->direccion;
            $row[] = $aSucursales[$i]->telefono;
            $row[] = $aSucursales[$i]->mapa;
            $row[] = $aSucursales[$i]->nombreEstado;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aSucursales), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aSucursales), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

}


?>