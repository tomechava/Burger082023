@extends('plantilla')

@section('titulo', $titulo)

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Postulaciones</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/postulacion/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/postulaciones");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php

use App\Entidades\Sistema\Postulacion;
$entidad = new Postulacion();
$aPostulaciones = $entidad->obtenerTodos();

if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Ver postulacion</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Descargar CV</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($aPostulaciones as $item)
            <tr>
                  <td><a href=""><i class="fa fa-eye"></i></a></td>
                  <td>{{$item->nombre}}</td>
                  <td>{{$item->apellido}}</td>
                  <td>{{$item->telefono}}</td>
                  <td>{{$item->correo}}</td>
                  <td><a href=""><i class="fa fa-download"></i></a></td>
            </tr>
      @endforeach
    </tbody>
</table> 
@endsection