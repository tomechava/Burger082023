@extends("web.web-plantilla")
@section("scripts")

@endsection
@section("contenido")
<div class="container py-5">
      <div class="row my-5">
            <div class="col-12">
                  <h1 class="h1">Mi Carrito <i class="fas fa-shopping-cart"></i></h1>
            </div>
      </div>
      <div class="row my-5">
            <div class="col-12">
                  <table class="table table-light my-5">
                        <thead>
                              <tr>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php $total = 0 ;?>
                              @foreach($productos as $producto)
                              <tr>  
                                    <td><img src="files/{{$producto->imagen}}" alt="Imagen del Producto" class="img-thumbnail" width="200px"></td>
                                    <td>{{$producto->nombre}}</td>
                                    <td>${{number_format($producto->precio, 2, ",", ".")}}</td>
                                    <td>{{$producto->cantidad}}</td>
                                    <td>${{number_format($producto->precio * $producto->cantidad, 2, ",", ".")}}</td>
                                    <td>
                                          <a href="#" class="btn btn-danger">Eliminar</a>
                                    </td>
                              </tr>
                              <?php $total += $producto->precio * $producto->cantidad;?>
                              @endforeach
                        </tbody>
                        <tfoot>
                              <tr>
                                    <td colspan="3" class="text-right">Total</td>
                                    <td>${{number_format($total, 2, ",", ".")}}</td>
                                    <td>
                                          <a href="#" class="btn btn-success">Pagar</a>
                                    </td>
                              </tr>
                        </tfoot>
                  </table>
            </div>
      </div>
</div>
@endsection
