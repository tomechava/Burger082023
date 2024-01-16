@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
      globalId = '';
      <?php $globalId = "";?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/productos">Productos</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
      </li>
      @if($globalId > 0)
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
      @endif
      <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
      function fsalir(){
      location.href ="/admin/productos";
      }
</script>
@endsection
@section('contenido')
<?php
use App\Entidades\Sistema\Categoria;
$categoria = new Categoria();
$aCategorias = $categoria->obtenerTodos();
?>
<div class="panel-body">
      <div id = "msg"></div>
      <?php
            if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
            }
      ?>
      <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Cantidad: *</label>
                    <input type="text" id="txtCantidad" name="txtCantidad" class="form-control" value="" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Precio: *</label>
                    <input type="number" id="txtPrecio" name="txtPrecio" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Categoría: *</label>
                    <select name="lstCategoria" id="lstCategoria" class="form-control">
                        <option value="" selected disabled>Seleccionar</option>
                        @foreach ($aCategorias as $categoria)
                        <option value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-12">
                    <label>Descripción: </label>
                    <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="row">
            <div class="form-group col-lg-6">
                    <label>Imagen: </label>
                    <input type="file" id="imgProducto" name="imgProducto" class="form-control" accept=".jpg, .jpeg, .png">
                </div>
            </div>
      </form>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#txtDescripcion' ) )
        .catch( error => {
            console.error( error );
        } );

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