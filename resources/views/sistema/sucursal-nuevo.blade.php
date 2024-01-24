@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
    globalId = '<?php echo isset($sucursal->idsucursal) && $sucursal->idsucursal > 0 ? $sucursal->idsucursal : 0; ?>';
    <?php $globalId = isset($sucursal->idsucursal) ? $sucursal->idsucursal : "0";?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/sucursales">Sucursales</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/sucursal/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
      </li>
      @if($globalId > 0)
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
      @endif
      <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
      function fsalir(){
      location.href ="/admin/sucursales";
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
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$sucursal->nombre}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Dirección: *</label>
                    <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="{{$sucursal->direccion}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Telefono: *</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" value="{{$sucursal->telefono}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Mapa: *</label>
                    <input type="text" id="txtMapa" name="txtMapa" class="form-control" value="{{$sucursal->mapa}}" required>
                </div>
            </div>
            <div class="row">
            <div class="form-group col-lg-6">
                    <label>Estado: *</label>
                    <select name="lstEstadoSucursal" id="lstEstadoSucursal" class="form-control" required>
                        <option value="" selected disabled>Seleccionar</option>
                        @foreach ($aEstados as $estado)
                        <option value="{{$estado->idestadosucursal}}" <?php echo $sucursal->fk_idestadosucursal==$estado->idestadosucursal? "selected" : ""; ?> >{{$estado->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
      </form>
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