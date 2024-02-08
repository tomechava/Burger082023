@extends("web.web-plantilla")
@section("contenido")
    <!-- Start Banner -->
    <section class="bg-black-dark py-5 mt-5">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-md-8 text-white">
                    <h1 class="h1 mb-5 text-orange-vibrant">Nosotros</h1>
                    <p>
                    En <span class="text-orange-vibrant"><b>BurgerHub</b></span>, nos apasiona servir hamburguesas excepcionales en un ambiente acogedor. 
                    Desde nuestros inicios, nos esforzamos por ofrecer calidad, sabor y servicio excepcional. 
                    ¡Ven y únete a nosotros para experimentar la diferencia en cada bocado!
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="web/images/image_8.jpg" alt="About Hero" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>
    <!-- Close Banner -->

    <!-- Start Section -->
    <section class="container py-5">
        <div class="row text-center text-light pt-5 pb-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Nuestro Servicio</h1>
                <p>
                    Algunos de los servicios que ofrecemos en 
                    <span class="text-orange-vibrant"><b>BurgerHub</b></span> son:
                </p>
            </div>
        </div>
        <div class="row text-light">

            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 py-5 services-icon-wap shadow">
                    <div class="h1 text-orange-vibrant text-center"><i class="fa fa-truck fa-lg"></i></div>
                    <h2 class="h5 mt-4 text-center">Servicio Takeaway</h2>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 py-5 services-icon-wap shadow">
                    <div class="h1 text-orange-vibrant text-center"><i class="fas fa-exchange-alt"></i></div>
                    <h2 class="h5 mt-4 text-center">Compensaciones y Devoluciones</h2>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 py-5 services-icon-wap shadow">
                    <div class="h1 text-orange-vibrant text-center"><i class="fa fa-percent"></i></div>
                    <h2 class="h5 mt-4 text-center">Promociones</h2>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 py-5 services-icon-wap shadow">
                    <div class="h1 text-orange-vibrant text-center"><i class="fa fa-user"></i></div>
                    <h2 class="h5 mt-4 text-center">Servicio 24 Horas</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section -->
@endsection