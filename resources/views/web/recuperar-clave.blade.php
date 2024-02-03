@extends("web.web-plantilla")
@section("contenido")
<div class="container my-5">
      <div class="row my-3">
            <div class="col-12 col-md-6 offset-md-3">
                  <h1 class="text-center h1">Recuperar contraseña</h1>
            </div>
      </div>
      <div class="row">
            <div class="col-12 col-md-4 offset-md-4 text-center">
                  <p>Ingresa tu correo electrónico para recuperar tu contraseña.</p>
            </div>
      </div>
      <div class="row mb-5 mt-2">
            <div class="col-12 col-md-6 offset-md-3">
                  <form method="POST" id="form1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <div class="form-group">
                              <label for="txtCorreo" class="h3">Correo</label>
                              <input type="text" class="form-control" id="txtCorreo" name="txtCorreo">
                        </div>
                        <div class="form-group text-center mt-5">
                              <button type="submit" class="btn btn-success">Recuperar contraseña</button>
                        </div>
                  </form>
                  <div class="row">
                        <div class="col-12">
                              @if (isset($msg))
                                    <div class="alert alert-{{$msg['ESTADO']}}" role="alert">
                                          {{$msg["MSG"]}}
                                    </div>
                              @endif
                        </div>
                  </div>
            </div>
      </div>
</div>
@endsection