@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0";?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
      <li class="breadcrumb-item active">Ver Pedido</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/pedido/{{$pedido->idpedido}}" class="fa fa-plus-circle" aria-hidden="true"><span>Recargar</span></a></li>
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a></li>
      <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
      function fsalir(){
      location.href ="/admin/pedidos";
      }
</script>
@endsection
@section('contenido')
<div class="panel-body">
      <div id = "msg"></div>
      <?php
            if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
            }
      ?>
      <div class="card">
            <div class="card-header">
                  <h5 class="mb-0">Pedido #{{$pedido->idpedido}}</h5>    
            </div>
            <div class="card-body">
                  <form id="form1" method="POST">
                        <div class="row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                        <div class="form-group col-lg-6">
                              <label>Cliente: </label>
                              <input type="text" class="form-control" value="{{$cliente->nombre}}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                              <label>Sucursal: </label>
                              <input type="text" class="form-control" value="{{$sucursal->nombre}}" readonly>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-lg-6">
                              <label>Fecha y Hora: </label>
                              <input type="text" class="form-control" value="{{$pedido->fecha}}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                              <label>Estado: </label>
                              <select name="lstEstadoPedido" id="lstEstadoPedido" class="form-control">
                                    <option value="" disabled>Seleccionar</option>
                                    @foreach ($estados as $estado)
                                    <option value="{{$estado->idestadopedido}}" {{$pedido->fk_idestadopedido == $estado->idestadopedido ? 'selected' : ''}}>{{$estado->nombre}}</option>
                                    @endforeach
                              </select>
                        </div>
                        </div>
                        <div class="row">
                              <div class="form-group col-lg-6">
                                    <label>Comentarios: </label>
                                    <textarea name="" id="" class="form-control" rows="3" readonly></textarea>
                              </div>
                              <div class="form-group col-lg-6">
                                    <label>Metodo de Pago: </label>
                                    <select name="lstMetodoPago" id="lstMetodoPago" class="form-control">
                                          <option value="" disabled>Seleccionar</option>
                                          <option value="1" {{$pedido->metodo_pago == 1 ? 'selected' : ''}}>Efectivo</option>
                                          <option value="2" {{$pedido->metodo_pago == 2 ? 'selected' : ''}}>MercadoPago</option>
                                    </select>
                              </div>
                        </div>
                  </form>
            </div>    
      </div>
      <div class="row my-5">
            <div class="col-lg-12">
                  <table class="table border">
                        <thead>
                              <th></th>
                              <th>Nombre</th>
                              <th>Cantidad</th>
                              <th>Extras</th>
                              <th>Ingredientes a Quitar</th>
                              <th>Precio</th>
                        </thead>
                        <tbody>
                              @foreach ($productos as $producto)
                              <tr>
                                    <td><img src="/public/files{{$producto->imagen}}" alt="Imagen del producto" class="img-thumbnail"></td>
                                    <td>{{$producto->nombre}}</td>
                                    <td>x{{$producto->cantidad}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>${{number_format($producto->precio_unitario, 2, ",", ".")}}</td>
                              </tr>
                              @endforeach
                        </tbody>   
                  </table>
            </div>
      </div>
</div>
<script>
    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
</script>
@endsection