<!doctype html>
<html lang="en">
<!--

Page    : index / MobApp
Version : 1.0
Author  : Colorlib
URI     : https://colorlib.com

 -->

<head>
    <title>sysReclamos | AGBC</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="sysReclamos | AGBC">
    <meta name="keywords" content="sysReclamos | AGBC">

    <!-- Font -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Main css -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="30">

    <!-- Nav Menu -->

    <div class="nav-menu fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-dark navbar-expand-lg">
                        <img id="logo" src="{{ asset('images/LOGOcen.png') }}" class="img-fluid" alt="logo"
                            style="max-width: 200px; height: auto;">
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="http://127.0.0.1:8000/">Inicio<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://correos.gob.bo/about/">Quienes Somos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://correos.gob.bo/services/">Nuestros Servicios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://correos.gob.bo/contact-us/">Contáctanos</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <header class="bg-gradient" id="home">
        <div class="container mt-5">
            <h1>Envianos tu Reclamo o Sugerencia</h1>
            <p class="tagline">En Correos, uno de nuestros recursos más valiosos para mejorar el servicio son las
                sugerencias, incidencias y consultas de nuestros clientes. Atenderlas con eficacia nos permite resolver
                los problemas planteados y prevenir inconvenientes futuros, garantizando así una mejor experiencia para
                nuestros clientes.</p>
        </div>
        <div class="img-holder mt-3"><img src="images/postal-realista-vendimia_97886-229.avif" alt="phone"
                class="img-fluid"></div>
    </header>

    <div class="section">
        <div class="container">
            <div class="section-title">
                <h5>Preguntas Frecuentes</h5>
                <h3>Tomar en cuenta lo siguiente</h3>
            </div>
            <div class="row pt-4">
                <div class="col-md-6">
                    <h4 class="mb-3">El paquete...</h4>
                    <p class="light-font mb-5">Mediante está opción podra realizar la reclamación sobre el servicio
                        postal prestado por un operador legal, con identificación y control individual cuyo peso
                        unitario no debe exceder los viente (20) Kilogramos.</p>
                    <h4 class="mb-3">El reclamo...</h4>
                    <p class="light-font mb-5">Es indespensable para el registro de su reclamación, identificar el
                        número guía de envío postal. </p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">El registro..</h4>
                    <p class="light-font mb-5">Usted tiene veinte (20) días hábiles, una vez suscitado el hecho, para
                        presentar su reclamación directa mediante nota, vía teléfono o de forma presencial ante la
                        oficina ODECO de su proveedor del servicio.</p>
                    <h4 class="mb-3">El seguimiento...</h4>
                    <p class="light-font mb-5">Cada reclamo tiene un numero de seguimiento con el cual podremos saber en
                        que estado esta nuestro reclamo </p>
                </div>
            </div>
        </div>
    </div>

    @livewire('Form-public')

    <div class="section light-bg" id="features">
        <div class="container">
            <div class="section-title">
                <h3>Proceso del tratamiento de una consulta</h3>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="card-title">Alta</h4>
                                    <p class="card-text">Cuando una persona realiza una consulta, esta se registra y se
                                        asigna un número de caso único. Este número sirve para rastrear y gestionar la
                                        consulta a lo largo de todo el proceso.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="card-title">Investigación y Análisis</h4>
                                    <p class="card-text">Se recopilan los datos necesarios para resolver la consulta.
                                        Con los datos recopilados, se analiza lo cuestionado por el cliente y se le
                                        ofrece la mejor respuesta.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="card-title">Respuesta</h4>
                                    <p class="card-text">Se proporciona una respuesta al cliente abordando los puntos
                                        planteados en su consulta. La respuesta se comunica de manera oportuna,
                                        garantizando que el cliente reciba la respuesta necesaria para resolver
                                        cualquier duda. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section light-bg">
            <div class="container">
                <h3 class="text-center">Cómo Enviar Tus Reclamos, Sugerencias e Incidencias</h3>
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center">
                        <ul class="list-unstyled ui-steps">
                            <li class="media">
                                <div class="circle-icon mr-4">1</div>
                                <div class="media-body">
                                    <h5>Página Web</h5>
                                    <p>Disponible las 24 horas del día. Horario de atención telefónica: Lunes a Viernes
                                        (no festivos) de 8:00 a 20:00 y Sábados de 9:00 a 13:00.</p>
                                </div>
                            </li>
                            <li class="media my-4">
                                <div class="circle-icon mr-4">2</div>
                                <div class="media-body">
                                    <h5>Línea Interna</h5>
                                    <p>Horario de atención: Lunes a Viernes (no festivos) de 8:00 a 20:00 y Sábados de
                                        9:00 a 13:00. Teléfono: +591 22152423</p>
                                </div>
                            </li>
                            <li class="media">
                                <div class="circle-icon mr-4">3</div>
                                <div class="media-body">
                                    <h5>Redes Sociales</h5>
                                    <p><strong>Facebook:</strong> Disponible las 24 horas. Horario de atención: Lunes a
                                        Viernes (no festivos) de 9:00 a 20:00. <a
                                            href="https://www.facebook.com/agbc.oficial">https://www.facebook.com/agbc.oficial</a>
                                    </p>
                                    <p><strong>X:</strong> Disponible las 24 horas. Horario de atención: Lunes a Viernes
                                        (no festivos) de 9:00 a 20:00. <a
                                            href="https://x.com/AGBC_oficial">https://x.com/AGBC_oficial</a></p>
                                    <p><strong>Instagram:</strong> Disponible las 24 horas. Horario de atención: Lunes a
                                        Viernes (no festivos) de 9:00 a 20:00. <a
                                            href="https://www.instagram.com/agbc_oficial">https://www.instagram.com/agbc_oficial</a>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <ul class="list-unstyled ui-steps">
                            <li class="media">
                                <div class="circle-icon mr-4">4</div>
                                <div class="media-body">
                                    <h5>Oficinas</h5>
                                    <p>Apersonate a nuestras oficinas en horarios de 8:00 a 20:00. Asegúrate de
                                        visitarnos durante estas horas para recibir la asistencia que necesitas.</p>
                                </div>
                            </li>
                            <li class="media my-4">
                                <div class="circle-icon mr-4">5</div>
                                <div class="media-body">
                                    <h5>Correo Electronico</h5>
                                    <p>Disponible 24 horas .Horario de atención de lunes a viernes no festivos: de 9 a
                                        20 horas.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <footer class="my-5 text-center">
            <!-- Copyright removal is not prohibited! -->
            <p class="mb-2"><small>#EstamosSaliendoAdelante #RumboalBicentenario</small></p>
            <p class="mb-2"><small>&copy; {{ date('Y') }} Todos los derechos reservados - Agencia
                    Boliviana de Correos <a href="mailto:mespinozarojas46@gmail.com" class="opacity-75"
                        title="Marco Antonio Espinoza Rojas">Copyright © MAER
                        {{ date('Y') }} </a></small></p>
            <p class="mb-2"><small>Contacto: (591-2) 2152423 - Av. Mariscal Santa Cruz Esq. C. Oruro Edif.
                    Telecomunicaciones - agbc@correos.gob.bo</small></p>
        </footer>


        <!-- jQuery and Bootstrap -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Plugins JS -->
        <script src="js/owl.carousel.min.js"></script>
        <!-- Custom JS -->
        <script src="js/script.js"></script>
        <script>
            document.addEventListener("scroll", function() {
                const navMenu = document.querySelector(".nav-menu");
                if (window.scrollY > 50) { // Ajusta el valor según cuándo quieras que ocurra el cambio
                    navMenu.classList.add("is-scrolling");
                } else {
                    navMenu.classList.remove("is-scrolling");
                }
            });
        </script>


</body>

</html>
