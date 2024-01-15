<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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
        $titulo = "Modificar Cliente";
    }


}


?>