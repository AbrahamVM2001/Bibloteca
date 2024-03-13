<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../assets/img/favicon.png">
    <title>Login |
        <?= constant('SOCIEDAD') ?>
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= constant('URL') ?>public/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= constant('URL') ?>public/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= constant('URL') ?>public/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= constant('URL') ?>public/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
    <!-- Exclusivo del login -->
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
</head>

<body class="bg-gray-100">
    <section class="background-radial-gradient overflow-hidden" style="height: 100vh;">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-12 mb-5 mb-lg-0 text-center" style="z-index: 10">
                    <h1 class="text-white mb-2 mt-5">Bienvenido!</h1>
                    <p class="text-lead text-white">
                        <?= constant('DESCRIPCIONSISTEMA') ?>
                    </p>
                </div>
            </div>

            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <div class="tab-content">
                                <!-- Pestaña de inicio de sesión -->
                                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                    <h4>Iniciar sesión</h4>
                                    <form id="form-new-iniciar" action="javascript:;" class="needs-validation" novalidate method="post">
                                        <div class="form-outline mb-4">
                                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo..." aria-label="Usuario" value="" required>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña..." aria-label="Password" value="" required>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="hidden" name="ip" id="ip" class="form-control" placeholder="Direccion" aria-label="Direccion" value="">
                                            <input type="hidden" name="modelo" id="modelo" class="form-control" placeholder="Modelo" aria-label="Modelo" value="">
                                        </div>
                                        <center><button id="btn-acceso" type="button" class="btn btn-lg btn-block btn-primary">Iniciar</button></center>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <div class="tab-content">
                                <!-- Pestaña de inicio de registro -->
                                <div class="tab-pane fade show active" id="pills-registro" role="tabpanel" aria-labelledby="tab-login" required>
                                    <h4>Iniciar tu proceso de registro</h4>
                                    <form id="form-new-registro" action="javascript:;" class="needs-validation" novalidate method="post">
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline mb-4">
                                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa tu nombre" aria-label="Nombre" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline mb-4">
                                                    <input type="text" name="apellido_paterno" id="apellido-paterno" class="form-control" placeholder="Ingresa tu apellido paterno" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline mb-4">
                                                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Ingresa tu apellido materno" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline mb-4">
                                                    <select title="Ingresa tu genero con el cual te identifiques." class="form-select" aria-label="Default select example" name="genero" id="genero">
                                                        <option>Sin genero</option>
                                                        <option>Hombre</option>
                                                        <option>Mujer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline mb-4">
                                                    <input type="email" name="correo" id="r_correo" class="form-control" placeholder="Ingresa tu correo electronicos" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <input type="password" name="pass" id="r_pass" class="form-control" placeholder="Ingresa tu contraseña" value="" required>
                                            </div>
                                        </div>
                                        <center><button id="btn-registro" type="button" class="btn btn-lg btn-block btn-primary">Registrar</button></center>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var infoDispositivo = obtener_info_dispositivo();
            var infoUbicacion = obtener_info_ubicacion();
            document.getElementById("modelo").value = infoDispositivo;
        });

        function obtener_info_dispositivo() {
            return navigator.userAgent;
        }

        function obtener_info_ubicacion() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;
                    obtener_direccion_completa(latitud, longitud);
                },
                function (error) {
                    console.error('Error al obtener la ubicación:', error.message);
                    document.getElementById("ip").value = 'Ubicación no disponible';
                }
            );
        } else {
            console.error('Geolocalización no soportada por el navegador.');
            document.getElementById("ip").value = 'Ubicación no disponible';
        }
    }

    function obtener_direccion_completa(latitud, longitud) {
        obtener_direccion_completa_openstreetmap(latitud, longitud);
    }
    function obtener_direccion_completa_openstreetmap(latitud, longitud) {
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${latitud}&lon=${longitud}&format=json`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                if (data.address) {
                    let formattedAddress = "";

                    if (data.address.road) {
                        formattedAddress += data.address.road;
                    }

                    if (data.address.house_number) {
                        formattedAddress += " " + data.address.house_number;
                    } else {
                        formattedAddress += " (sin número)";
                    }

                    if (data.address.city) {
                        formattedAddress += ", " + data.address.city;
                    }

                    if (data.address.country_name) {
                        formattedAddress += ", " + data.address.country_name;
                    }

                    document.getElementById("ip").value = formattedAddress.trim();
                } else {
                    console.error('Error al obtener la dirección:', data.error);
                    document.getElementById("ip").value = 'Dirección no disponible';
                }
            })
            .catch((error) => {
                console.error('Error en la solicitud:', error);
                document.getElementById("ip").value = 'Error en la solicitud';
            });
        }
    </script>
    <script>
        let servidor = '<?= constant('URL') ?>';
    </script>
    <script src="<?= constant("URL") ?>public/js/plugins/jquery/jquery.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/core/popper.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/core/bootstrap.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="<?= constant('URL') ?>public/js/plugins/dragula/dragula.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/plugins/jkanban/jkanban.js"></script>
    <!-- Select2 -->
    <script src="<?php echo constant("URL"); ?>public/plugins/select2/js/select2.full.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="<?= constant('URL') ?>public/js/github.buttons.js"></script>
    <script src="<?= constant('URL') ?>public/js/fontawesome-4f9827e774.js"></script>
    <script src="<?= constant('URL') ?>public/js/sweetalert.min.js"></script>
    <script src="<?= constant('URL') ?>public/js/paginas/login.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= constant('URL') ?>public/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
</body>

</html>