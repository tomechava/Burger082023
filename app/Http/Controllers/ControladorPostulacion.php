<?php 

namespace App\Http\Controllers;

class ControladorPostulacion extends Controller {

      public function nuevo()
    {
        $titulo = "Nueva Postulacion";
        return view('sistema.postulacion-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Postulaciones";
            return view('sistema.postulacion-listar', compact('titulo'));
    }
}


?>