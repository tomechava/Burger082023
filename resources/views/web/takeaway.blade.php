@extends("web.web-plantilla")
@section("contenido")
    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-9 m-auto">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu mb-3 pt-3">
                            <li class="list-inline-item">
                                <a class="h3 text-light text-decoration-none mr-3" href="#">Todos</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-light text-decoration-none mr-3" href="#">Burgers</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-light text-decoration-none mr-3" href="#">Papas</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-light text-decoration-none" href="#">Bebidas</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    @if (isset($msg))
                        <div class="alert alert-{{$msg['ESTADO']}}" role="alert">
                            {{ $msg["MSG"] }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    @foreach($aProductos as $producto)
                    <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0 card-color-black">
                            <form method="POST" id="form1">
                                <div class="card rounded-0 border-black">
                                    <img class="card-img rounded-0 img-fluid" src="files/{{$producto->imagen}}">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-orange-intense text-white mt-2" href="takeaway-producto/{{$producto->idproducto}}"><i class="far fa-eye"></i></a></li>
                                            <li><button type="submit" class="btn btn-orange-intense my-3"><i class="fas fa-cart-plus"></i></button></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body d-block text-light">
                                    <a href="#" class="h2 text-light d-block">{{$producto->nombre}}</a>
                                    <p class="text-right mb-3">${{number_format($producto->precio, 0, ",", ".")}}</p>
                                    
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                    <input type="hidden" name="txtIdProducto" id="txtIdProducto" value="{{$producto->idproducto}}">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="txtCantidad" class="form-label">Cantidad:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control bg-dark" name="txtCantidad" id="txtCantidad" placeholder="1" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div div="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- End Content -->
@endsection