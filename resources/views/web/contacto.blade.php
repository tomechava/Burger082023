@extends("web.web-plantilla")
@section("contenido")
    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contacto</h1>
            <p>
                Trabaja con nosotros. Envíanos tu información y nos pondremos en contacto contigo.
            </p>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="POST" id="form1" enctype="multipart/form-data">
                @if (isset($msg))
                    <div class="alert alert-{{$msg['ESTADO']}}" role="alert">
                        {{ $msg["MSG"] }}
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <label for="txtNombre">Nombre</label>
                        <input type="text" class="form-control mt-1" id="txtNombre" name="txtNombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="txtApellido">Apellido</label>
                        <input type="text" class="form-control mt-1" id="txtApellido" name="txtApellido" placeholder="Apellido" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="txtCorreo">Correo</label>
                        <input type="email" class="form-control mt-1" id="txtCorreo" name="txtCorreo" placeholder="Correo" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="txtTelefono">Teléfono</label>
                        <input type="text" class="form-control mt-1" id="txtTelefono" name="txtTelefono" placeholder="Teléfono" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="txtDireccion">Dirección</label>
                        <input type="text" class="form-control mt-1" id="txtDireccion" name="txtDireccion"  placeholder="Dirección">
                    </div>
                    <div class="form-group col-lg-6">
                        <label>CV:</label>
                        <input type="file" id="archivo" name="archivo" class="form-control" accept=".png, .doc, .docx, .txt" required>
                        <small class="d-block">Archivos admitidos: .png .doc .docx .txt</small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                        <label for="txtMensaje">Mensaje</label>
                        <textarea class="form-control mt-1" id="txtMensaje" name="txtMensaje" placeholder="Mensaje"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3 text-right">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->
@endsection