@extends("web.web-plantilla")
@section("contenido")
<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide my-5 bg-tinted-windows" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active bg-orange-vibrant"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1" class="bg-orange-vibrant"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2" class="bg-orange-vibrant"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active text-white">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid rounded shadow" src="web/images/grill.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-orange-vibrant">Sabor y calidad</h1>
                                <p>
                                En BurgerHub, nos enorgullecemos de ofrecer una experiencia gastronómica 
                                excepcional que deleitará tus sentidos. Nuestras hamburguesas, preparadas 
                                con ingredientes frescos y de la más alta calidad, son una delicia para el 
                                paladar y una experiencia que no olvidarás.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item text-white ">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid rounded shadow" src="web/images/gallery-4.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-orange-vibrant">Velocidad y conveniencia </h1>
                                <p>
                                Disfruta de la comodidad sin precedentes con nuestro servicio de comida 
                                para llevar. Con solo unos clics, tendrás nuestras deliciosas hamburguesas 
                                listas para llevar a casa, para que puedas satisfacer tus antojos sin 
                                esperas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item text-white">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid rounded shadow" src="web/images/image_11.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-orange-vibrant">Pasión por la calidad </h1>
                                <p>
                                En BurgerHub, nuestra pasión por la calidad se refleja en cada detalle. 
                                Desde la cuidadosa selección de los ingredientes hasta la meticulosa 
                                preparación de cada hamburguesa, nos esforzamos por ofrecerte una 
                                experiencia gastronómica excepcional que dejará una impresión duradera.                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-solid fa-chevron-left" style="color: #ff5733 !important;"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-solid fa-chevron-right" style="color: #ff5733 !important;"></i>
        </a>
    </div>
    <!-- End Banner Hero -->


    <!-- Start Categories of The Month -->
    <section class="container py-5 text-light">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Productos Destacados</h1>
                <p>
                    Algunos de nuestros productos más populares este mes.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="files/{{$producto1->imagen}}" class="rounded-circle img-fluid border"></a>
                <h5 class="text-center mt-3 mb-3">{{$producto1->nombre}}</h5>
                <p class="text-center"><a class="btn btn-orange-intense" href="takeaway">Comprar</a></p>
            </div>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="files/{{$producto2->imagen}}" class="rounded-circle img-fluid border"></a>
                <h2 class="h5 text-center mt-3 mb-3">{{$producto2->nombre}}</h2>
                <p class="text-center"><a class="btn btn-orange-intense" href="takeaway">Comprar</a></p>
            </div>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="files/{{$producto3->imagen}}" class="rounded-circle img-fluid border"></a>
                <h2 class="h5 text-center mt-3 mb-3">{{$producto3->nombre}}</h2>
                <p class="text-center"><a class="btn btn-orange-intense" href="takeaway">Comprar</a></p>
            </div>
        </div>
    </section>
    <!-- End Categories of The Month -->

@endsection