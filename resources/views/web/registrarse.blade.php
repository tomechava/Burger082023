@extends("web.web-plantilla")

@section("contenido")
<div class="container my-5">
      <div class="row">
            <div class="col-12 col-md-6 mt-4 mb-5">
                  <h1 class="h1">Registrarse</h1>
            </div>
      </div>
      @if (isset($msg))
            <div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
                  {{ $msg["MSG"] }}
            </div>
      @endif
      <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">Apellido: *</label>
                    <input type="text" id="txtApellido" name="txtApellido" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">DNI: *</label>
                    <input type="text" id="txtDni" name="txtDni" class="form-control"required>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">Telefono: *</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" class="form-control"" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">Correo: *</label>
                    <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-orange-vibrant">Clave: *</label>
                    <input type="text" id="txtClave" name="txtClave" class="form-control" required>
                </div>
            </div>
            <div class="row">
                  <div class="col-lg-12 text-center my-3">
                        <button type="submit" class="btn btn-orange-intense">Registrarse</button>
                  </div>
            </div>
      </form>
</div>
@endsection