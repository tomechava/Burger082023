@extends('plantilla')

@section('titulo', $titulo)

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Pedidos</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/pedidos");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php

use App\Http\Sistema\Entidades\Pedido;
$entidad = new Pedido();
$aPedidos = $entidad->obtenerTodos();

if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Ver pedido</th>
            <th>NPedido</th>
            <th>Sucursal</th>
            <th>Cliente</th>
            <th>Celular</th>
            <th>Fecha</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            <td>{{$pedido->idpedido}}</td>
            <td>{{$pedido->sucursal->nombre}}</td>
            <td>{{$pedido->cliente->nombre}}</td>
            <td>{{$pedido->cliente->celular}}</td>
            <td>{{$pedido->fecha}}</td>
            <td>{{$pedido->total}}</td>
        </tr>
        @endforeach
    </tbody>
</table> 
@endsection