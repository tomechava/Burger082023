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
            <h1 class="h1">Login</h1>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container bg-light shadow rounded pt-1 pb-1 mb-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="POST" id="form1">
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
                        <div class="form-group col-12 mb-3">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                              <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                              <label for="txtCorreo" class="form-label h3">Correo</label>
                              <input type="text" class="form-control" id="txtCorreo" name="txtCorreo">
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-12 mb-3 hover">
                            <label for="txtClave" class="form-label h3">Contraseña</label>
                            <input type="password" class="form-control" id="txtClave" name="txtClave">
                        </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-12 mt-3 text-center">
                            <button type="submit " class="btn btn-success">Ingresar</button>
                        </div>
                  </div>
                  <div class="row text-center">
                        <div class="col-12 mt-1">
                              <a href="#" class="text-success">¿Olvidaste la clave?</a>
                        </div>
                  </div>
                  <div class="row text-center">
                        <div class="col-12 mt-1">
                              <a href="#" class="text-success">¿No tienes cuenta? Registrate</a>
                        </div>
                  </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->
@endsection