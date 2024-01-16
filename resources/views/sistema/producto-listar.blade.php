@extends('plantilla')

@section('titulo', $titulo)

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Productos</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/productos");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php

use App\Entidades\Sistema\Producto;
$entidad = new Producto();
$aProductos = $entidad->obtenerTodos();

if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($aProductos as $item)
        <tr>
            <td><a href="">{{$item->nombre}}</a></td>
            <td>{{$item->fk_idcategoria}}</td>
            <td>{{$item->precio}}</td>
        </tr>
        @endforeach
    </tbody>
</table> 
@endsection