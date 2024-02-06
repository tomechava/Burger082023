@extends("web.web-plantilla")
@section('contenido')
<div class="container">
      <div class="row my-5">
            <div class="col-md-6 m-auto text-center">
                  <h1 class="h1">Pedido #{{$pedido->idpedido}}</h1>
            </div>
      </div>
</div>
<div class="container">
      <div class="row">
            <div class="col-md-6 m-auto">
                  <div class="row my-3">
                        <div class="col-12 mb-3">
                              <h2 class="h2">Datos del pedido</h2>
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-6 mb-3">
                              <label for="txtFecha" class="form-label h3">Fecha</label>
                              <input type="disabled" class="form-control" value="{{$pedido->fecha}}" readonly>
                        </div>
                        <div class="form-group col-6 mb-3">
                              <label for="txtFecha" class="form-label h3">Cliente</label>
                              <input type="disabled" class="form-control" value="{{$pedido->nombreCliente}} {{$pedido->apellidoCliente}}" readonly>
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-6 mb-3">
                              <label for="txtTotal" class="form-label h3">Sucursal</label>
                              <input type="disabled" class="form-control" value="{{$pedido->nombreSucursal}}" readonly>
                        </div>
                        <div class="form-group col-6 mb-3">
                              <label for="txtTotal" class="form-label h3">Total</label>
                              <input type="disabled" class="form-control" value="${{number_format($pedido->total, 2, ',', '.')}}" readonly>
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-6 mb-3">
                              <label for="txtFecha" class="form-label h3">Estado</label>
                              <input type="disabled" class="form-control" value="{{$pedido->nombreEstado}}" readonly>
                        </div>
                        <div class="form-group col-6 mb-3">
                              <label for="txtTotal" class="form-label h3">Metodo de Pago</label>
                              <input type="disabled" class="form-control" value="{{$pedido->metodo_pago}}" readonly>
                        </div>
                  </div>
                  <div class="row mb-5">
                        <div class="form-group col-12 mb-3">
                              <label for="txtFecha" class="form-label h3">Comentarios</label>
                              <input type="disabled" class="form-control" value="{{$pedido->comentario}}" readonly>
                        </div>
                  </div>
            </div>
      </div>
</div>
<div class="container">
      <div class="row mt-5 mb-3">
            <div class="col-12 text-center">
                  <h2 class="h2">Detalle del pedido</h2>
            </div>
      </div>
</div>
<div class="container">
      <div class="row mb-5">
            <div class="col-12">
                  <table class="table">
                        <thead>
                              <tr>
                                    <th class="h3">Producto</th>
                                    <th class="h3">Cantidad</th>
                                    <th class="h3">Precio</th>
                                    <th class="h3">Subtotal</th>
                              </tr>
                        </thead>
                        <tbody>
                              @foreach($aProductos as $producto)
                              <tr>
                                    <td>{{$producto->nombre}}</td>
                                    <td>{{$producto->cantidad}}</td>
                                    <td>${{number_format($producto->precio_unitario, 2, ',', '.')}}</td>
                                    <td>${{number_format($producto->precio_unitario * $producto->cantidad, 2, ',', '.')}}</td>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>
            </div>
      </div>
      <div class="row mb-5">
            <div class="col-12 text-center">
                  <a href="/mi-cuenta" class="btn btn-success"><i class="fa fa-fw fa-solid fa-arrow-left"></i> Volver</a>
            </div>
      </div>
</div>
@endsection