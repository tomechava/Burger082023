<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ControladorCategoria extends Controller {

      public function nuevo()
    {
        $titulo = "Nueva Categoría";
        return view('sistema.categoria-nuevo', compact('titulo'));

    }

    public function index()
    {
            $titulo = "Listado de Categorías";
            return view('sistema.categoria-listar', compact('titulo'));
    }

    public function guardar(Request $request){
        $titulo = "Modificar Categoría";
    }


}


?>