@extends("web.web-plantilla")
@section('scripts')
<script>
    globalId = '';
    <?php $globalId = "";?>
</script>
@endsection
@section("contenido")

<!-- Start Content Page -->
<div class="container-fluid py-5">
      <div class="col-md-6 m-auto text-center">
      <h1 class="h1">Mi cuenta</h1>
      </div>
</div>

<!-- Start Contact -->
<div class="container-fluid bg-light rounded pt-1 pb-1">
      <div class="row py-5">
            <form class="col-md-9 m-auto" method="POST" id="form1">
                  <div class="row">
                        <div class="col-12 mb-3">
                              <h2 class="h2">Datos personales</h2>
                        </div>
                  </div>
                  @if (isset($msg))
                        <div class="row">
                              <div class="col-12">
                                    <div class="alert alert-{{$msg['ESTADO']}}" role="alert">
                                          {{$msg["MSG"]}}
                                    </div>
                              </div>
                        </div> 
                  @endif
                  <div class="row">
                        <div class="form-group col-lg-6 col-12 mb-3">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                              <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                              <label for="txtNombre" class="form-label h3">Nombre</label>
                              <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="{{$cliente->nombre}}">
                        </div>
                        <div class="form-group col-lg-6 col-12 mb-3">
                              <label for="txtApellido" class="form-label h3">Apellido</label>
                              <input type="text" class="form-control" id="txtApellido" name="txtApellido" value="{{$cliente->apellido}}">
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-lg-6 col-12 mb-3">
                              <label for="txtCorreo" class="form-label h3">Correo</label>
                              <input type="text" class="form-control" id="txtCorreo" name="txtCorreo" value="{{$cliente->correo}}">
                        </div>
                        <div class="form-group col-lg-6 col-12 mb-3">
                              <label for="txtTelefono" class="form-label h3">Teléfono</label>
                              <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" value="{{$cliente->telefono}}">
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-12 mt-3 text-center">
                              <button type="submit " class="btn btn-success h3">Guardar</button>
                        </div>
                  </div>
            </form>
      </div>
</div>
<div class="container">
      <div class="row my-5 py-5">
            <div class="col-12">
                  <table class="table">
                        <thead>
                              <tr>
                                    <th class="h3">Nro. Pedido</th>
                                    <th class="h3">Fecha</th>
                                    <th class="h3">Sucursal</th>
                                    <th class="h3">Total</th>
                                    <th class="h3">Estado</th>
                                    <th class="h3">Acciones</th>
                              </th>
                        </thead>
                        <tbody>
                              @foreach($pedidos as $pedido)
                              <tr>
                                    <td>{{$pedido->idpedido}}</td>
                                    <td>{{$pedido->fecha}}</td>
                                    <td>{{$pedido->nombreSucursal}}</td>
                                    <td>${{number_format($pedido->total, 2, ",", ".")}}</td>
                                    <td>{{$pedido->nombreEstado}}</td>
                                    <td>
                                          <a href="/pedido?id={{$pedido->idpedido}}" class="btn btn-success">Ver</a>
                                    </td>
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
            return false;
        }
    }
</script>
@endsection

                  