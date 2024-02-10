@extends("web.web-plantilla")
@section("scripts")

@endsection
@section("contenido")
<form method="POST" id="form1">
<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
<div class="container py-5">
      <div class="row my-5 text-light">
            <div class="col-12">
                  <h1 class="h1">Mi Carrito <i class="fas fa-shopping-cart"></i></h1>
            </div>
      </div>
      {{-- Si no hay productos en el carrito --}}
      @if(count($productos) == 0)
            <div class="row my-5 text-center bg-black-dark text-light rounded shadow p-5">
                  <div class="col-12">
                        <h2 class="h2">No hay productos en el carrito</h2>
                  </div>
            </div>
            <div class="row my-5">
                  <div class="col-12 text-center">
                        <a href="takeaway" class="btn btn-orange-vibrant">Ver productos</a>
                  </div>
            </div>
      @elseif(count($productos) > 0)
      {{-- Si hay productos en el carrito --}}
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
                                          <td>${{number_format($producto->precio, 0, ",", ".")}}</td>
                                          <td>{{$producto->cantidad}}</td>
                                          <td>${{number_format($producto->precio * $producto->cantidad, 0, ",", ".")}}</td>
                                          <td>  
                                                <a href="carrito/eliminar?id={{$producto->idproducto}}" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i></a>
                                          </td>
                                    </tr>
                                    <?php $total += $producto->precio * $producto->cantidad;?>
                                    @endforeach
                              </tbody>
                              <tfoot>
                                    <tr class="border-bottom">
                                          <td colspan="4" class="text-right h2"><input type="hidden" name="txtTotal" value="{{$total}}">Total</td>
                                          <td colspan="2" class="h2" >${{number_format($total, 0, ",", ".")}}</td>
                                    </tr>
                                    <tr>
                                          <td class="text-right">
                                                <label for="lstMetodoDePago" >Método de pago:</label>
                                          </td>
                                          <td>
                                                <select name="lstMetodoDePago" id="lstMetodoDePago" class="form-control" required>
                                                      <option value="" selected disabled>Seleccionar</option>
                                                      <option value="sucursal">Pago en sucursal</option>
                                                      <option value="mercadopago">MercadoPago</option>
                                                </select>
                                          </td>
                                          <td class="text-right">
                                                <label for="lstSucursales" >Sucursal:</label>
                                          </td>
                                          <td>
                                                <select name="lstSucursales" id="lstSucursales" class="form-control" required>
                                                <option value="" selected disabled>Seleccionar</option>
                                                      @foreach($aSucursales as $sucursal)
                                                      <option value="{{$sucursal->idsucursal}}">{{$sucursal->nombre}}</option>
                                                      @endforeach
                                                </select>
                                          </td>
                                    </tr>
                                    <tr>
                                          <td class="text-right">
                                                <label for="txtComentario">Comentarios:</label>
                                          </td>
                                          <td colspan="3">
                                                <textarea name="txtComentario" id="txtComentario" class="form-control" rows="3"></textarea>
                                          </td>
                                    </tr>
                                    <tr>
                                          <td colspan="6" class="text-center">
                                                <button class="btn btn-orange-vibrant" type="submit" name="btnComprar">Comprar</button>
                                          </td>
                              </tfoot>
                        </table>
                  </div>
            </div>
      @endif
      {{-- Fin del carrito --}}
</div>
</form>
@endsection
