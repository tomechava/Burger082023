<?php 

namespace App\Http\Controllers;

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

}


?>