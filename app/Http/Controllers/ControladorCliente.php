<?php 

namespace App\Http\Controllers;

class ControladorCliente extends Controller {

      public function nuevo()
    {
        $titulo = "Nuevo Cliente";
        return view('sistema.cliente-nuevo', compact('titulo'));

    }


}


?>