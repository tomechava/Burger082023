<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Pedido;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                $codigo = "CLIENTEALTA";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $cliente = new Cliente();
                return view('sistema.cliente-nuevo', compact('titulo', 'cliente'));

            }
        }else{
            return redirect('admin/login');
        }

    }

    public function index()
    {

            $titulo = "Listado de Clientes";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CLIENTECONSULTA")) {
                    $codigo = "CLIENTECONSULTA";
                    $mensaje = "No tiene pemisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
    
                } else {
                    return view('sistema.cliente-listar', compact('titulo'));
                }
            }else{
                return redirect('admin/login');
            }
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
    
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Cliente();
        $aClientes = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/cliente/' . $aClientes[$i]->idcliente . '" class="btn btn-secondary">Editar</a>';
            $row[] = $aClientes[$i]->nombre;
            $row[] = $aClientes[$i]->apellido;
            $row[] = $aClientes[$i]->dni;
            $row[] = $aClientes[$i]->telefono;
            $row[] = $aClientes[$i]->correo;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar Cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $cliente = new Cliente();
                $cliente->obtenerPorId($id);

                return view('sistema.cliente-nuevo', compact( 'titulo', 'cliente'));
            }
        } else { 
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEELIMINAR")) {
                $codigo = "CLIENTEELIMINAR";
                $mensaje = "No tiene pemisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));

            } else {
                $id = $request->input("id");

                //Si no tiene pedidos asociados, lo elimino
                $pedido = new Pedido();
                $aPedidos = $pedido->obtenerPorCliente($id);

                if(count($aPedidos)==0){
                    $cliente = new Cliente();
                    $cliente->idcliente = $id;
                    $cliente->eliminar();
                    $data["err"] = "OK";

                }else{
                    $data["err"] = "No se puede eliminar el cliente con pedidos asociados";
                
                }
                return json_encode($data);
            }
        } else { 
            return redirect('admin/login');
        }

    }

}


?>