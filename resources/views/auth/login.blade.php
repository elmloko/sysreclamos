<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inicio Session sysReclamos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('vendor/adminlte/dist/img/AGBClogo.png') }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Linearicons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <!-- Animsition CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link href="css/login.css" rel="stylesheet">
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/sobres.jpg');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <div class="login100-form-title p-b-53">
                    <h4>SISTEMA DE RECLAMOS Y CONSULTAS</h4>
                    <h5>"SIRECO"</h5>
                </div>
                <form class="login100-form validate-form flex-sb flex-w" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title p-b-53">
                        Iniciar sesión
                    </span>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1">
                            Correo Electronico
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Correos Electronico Requerido">
                        <input class="input100" type="email" name="email" value="{{ old('email') }}" required
                            autofocus>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Contraseña
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Contraseña Requerida">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LdIqDcqAAAAAACT4SftkCarELry37YxM2cPRaJi"></div>
                    @error('g-recaptcha-response')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button class="login100-form-btn">
                        Ingresar
                    </button>
            </div>

            </form>
        </div>
    </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        (function($) {
            "use strict";


            /*==================================================================
            [ Validate ]*/
            var input = $('.validate-input .input100');

            $('.validate-form').on('submit', function() {
                var check = true;

                for (var i = 0; i < input.length; i++) {
                    if (validate(input[i]) == false) {
                        showValidate(input[i]);
                        check = false;
                    }
                }

                return check;
            });


            $('.validate-form .input100').each(function() {
                $(this).focus(function() {
                    hideValidate(this);
                });
            });

            function validate(input) {
                if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                    if ($(input).val().trim().match(
                            /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/
                        ) == null) {
                        return false;
                    }
                } else {
                    if ($(input).val().trim() == '') {
                        return false;
                    }
                }
            }

            function showValidate(input) {
                var thisAlert = $(input).parent();

                $(thisAlert).addClass('alert-validate');
            }

            function hideValidate(input) {
                var thisAlert = $(input).parent();

                $(thisAlert).removeClass('alert-validate');
            }
        })(jQuery);
    </script>
</body>

</html>
