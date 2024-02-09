<?php

namespace App\Http\Controllers;
use App\Entidades\Sistema\Producto;
use Session;

class ControladorWebHome extends Controller
{
    public function index()
    {   
        $producto1 = new Producto();
        $producto1 = $producto1->obtenerPorId(15);
        $producto2 = new Producto();
        $producto2 = $producto2->obtenerPorId(20);
        $producto3 = new Producto();
        $producto3 = $producto3->obtenerPorId(22);
        return view('web.index', compact('producto1', 'producto2', 'producto3'));
    }
}
