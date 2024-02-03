@extends("web.web-plantilla")
@section("contenido")
<div class="container my-5">
      <div class="row my-3">
            <div class="col-12 col-md-6 offset-md-3">
                  <div class="alert alert-success py-5" role="alert">
                        <h3 class="h3">Su contraseña ha sido recuperada con éxito. Su nueva contraseña es:</h3>
                        <h1 class="h1 text-center">{{$claveNueva}}</h1>
                  </div>
            </div>
      </div>
</div>
@endsection