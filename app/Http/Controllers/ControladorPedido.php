<?php 

namespace App\Http\Controllers;

class ControladorPedido extends Controller {

      public function index()
    {
            $titulo = "Listado de Pedidos";
            return view('sistema.pedido-listar', compact('titulo'));
    }

}


?>