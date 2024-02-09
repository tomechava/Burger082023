@extends("web.web-plantilla")
@section("scripts")

@endsection
@section("contenido")
<div class="container py-5">
      <div class="row my-5 text-light">
            <div class="col-12">
                  <h1 class="h1">Mi Carrito <i class="fas fa-shopping-cart"></i></h1>
            </div>
      </div>
      <div class="row my-5">
            <div class="col-12">
                  <table class="table table-hover table-dark border-none my-5 shadow table-borderless">
                        <thead>
                              <tr>
                                    <th></th>
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
                                    <td><img src="files/{{$producto->imagen}}" alt="Imagen del Producto" class="img-thumbnail border border-0 p-0 shadow" width="200px"></td>
                                    <td>{{$producto->nombre}}</td>
                                    <td>${{number_format($producto->precio, 2, ",", ".")}}</td>
                                    <td>{{$producto->cantidad}}</td>
                                    <td>${{number_format($producto->precio * $producto->cantidad, 2, ",", ".")}}</td>
                                    <td>  
                                          <a href="carrito/eliminar?id={{$producto->idproducto}}" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i></a>
                                    </td>
                              </tr>
                              <?php $total += $producto->precio * $producto->cantidad;?>
                              @endforeach
                        </tbody>
                        <tfoot>
                              <tr>
                                    <td colspan="4" class="text-right">Total</td>
                                    <td colspan="2" >${{number_format($total, 2, ",", ".")}}</td>
                              </tr>
                              <tr>
                                    <td colspan="4" class="text-right">
                                          <label for="">Método de pago:</label>
                                    </td>
                                    <td colspan="2">
                                          <select name="lstMetodoDePago" id="lstMetodoDePago" class="form-control">
                                                <option value="sucursal">Pago en sucursal</option>
                                                <option value="mercadopago">MercadoPago</option>
                                          </select>
                                    </td>
                              </tr>
                        </tfoot>
                  </table>
            </div>
      </div>
</div>
@endsection
