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
    <style>
        @font-face {
            font-family: Poppins-Regular;
            src: url('../fonts/poppins/Poppins-Regular.ttf');
        }

        @font-face {
            font-family: Poppins-Medium;
            src: url('../fonts/poppins/Poppins-Medium.ttf');
        }

        @font-face {
            font-family: Montserrat-Medium;
            src: url('../fonts/montserrat/Montserrat-Medium.ttf');
        }

        @font-face {
            font-family: Montserrat-SemiBold;
            src: url('../fonts/montserrat/Montserrat-SemiBold.ttf');
        }

        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            font-family: Poppins-Regular, sans-serif;
        }

        a {
            font-family: Poppins-Regular;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0px;
            transition: all 0.4s;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
        }

        a:focus {
            outline: none !important;
        }

        a:hover {
            text-decoration: none;
            color: #34447C;
            border-color: #;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0px;
        }

        p {
            font-family: Poppins-Regular;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0px;
        }

        ul,
        li {
            margin: 0px;
            list-style-type: none;
        }

        input {
            outline: none;
            border: none;
        }

        textarea {
            outline: none;
            border: none;
        }

        textarea:focus,
        input:focus {
            border-color: transparent !important;
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        input:focus:-moz-placeholder {
            color: transparent;
        }

        input:focus::-moz-placeholder {
            color: transparent;
        }

        input:focus:-ms-input-placeholder {
            color: transparent;
        }

        textarea:focus::-webkit-input-placeholder {
            color: transparent;
        }

        textarea:focus:-moz-placeholder {
            color: transparent;
        }

        textarea:focus::-moz-placeholder {
            color: transparent;
        }

        textarea:focus:-ms-input-placeholder {
            color: transparent;
        }

        input::-webkit-input-placeholder {
            color: #555555;
        }

        input:-moz-placeholder {
            color: #555555;
        }

        input::-moz-placeholder {
            color: #555555;
        }

        input:-ms-input-placeholder {
            color: #555555;
        }

        textarea::-webkit-input-placeholder {
            color: #555555;
        }

        textarea:-moz-placeholder {
            color: #555555;
        }

        textarea::-moz-placeholder {
            color: #555555;
        }

        textarea:-ms-input-placeholder {
            color: #555555;
        }

        label {
            display: block;
            margin: 0;
        }

        button {
            outline: none !important;
            border: none;
            background: transparent;
        }

        button:hover {
            cursor: pointer;
        }

        iframe {
            border: none !important;
        }

        .txt1 {
            font-family: Montserrat-SemiBold;
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }

        .txt2 {
            font-family: Poppins-Regular;
            font-size: 14px;
            color: #999999;
            line-height: 1.5;
        }

        .bo1 {
            border-bottom: 1px solid #999999;
        }

        .limiter {
            width: 100%;
            margin: 0 auto;
        }

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .wrap-login100 {
            width: 680px;
            background: #fff;
            border-radius: 10px;
            position: relative;
            padding: 33px 55px 55px 55px;
            box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .login100-form {
            width: 100%;
        }

        .login100-form-title {
            width: 100%;
            display: block;
            font-family: Montserrat-Medium;
            font-size: 39px;
            color: #555555;
            line-height: 1.2;
            text-align: center;
        }

        .wrap-input100 {
            width: 100%;
            position: relative;
            background-color: #f7f7f7;
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .input100 {
            font-family: Poppins-Regular;
            color: #333333;
            line-height: 1.2;
            font-size: 18px;
            display: block;
            width: 100%;
            background: transparent;
            height: 60px;
            padding: 0 20px;
        }

        .focus-input100 {
            position: absolute;
            display: block;
            width: calc(100% + 2px);
            height: calc(100% + 2px);
            top: -1px;
            left: -1px;
            pointer-events: none;
            border: 1px solid #B99C46;
            border-radius: 10px;
            visibility: hidden;
            opacity: 0;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
            -webkit-transform: scaleX(1.1) scaleY(1.3);
            -moz-transform: scaleX(1.1) scaleY(1.3);
            -ms-transform: scaleX(1.1) scaleY(1.3);
            -o-transform: scaleX(1.1) scaleY(1.3);
            transform: scaleX(1.1) scaleY(1.3);
        }

        .input100:focus+.focus-input100 {
            visibility: visible;
            opacity: 1;
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }

        .container-login100-form-btn {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
        }

        .login100-form-btn {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            width: 100%;
            height: 60px;
            background-color: #333333;
            border-radius: 10px;
            font-family: Poppins-Medium;
            font-size: 16px;
            color: #fff;
            line-height: 1.2;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
            position: relative;
            z-index: 1;
        }

        .login100-form-btn::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            top: 0;
            left: 0;
            background: #a64bf4;
            background: -webkit-linear-gradient(45deg, #34447C, #B99C46);
            background: -o-linear-gradient(45deg, #34447C, #B99C46);
            background: -moz-linear-gradient(45deg, #34447C, #B99C46);
            background: linear-gradient(45deg, #34447C, #B99C46);
            opacity: 0;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .login100-form-btn:hover:before {
            opacity: 1;
        }

        .validate-input {
            position: relative;
        }

        .alert-validate::before {
            content: attr(data-validate);
            position: absolute;
            max-width: 70%;
            background-color: #fff;
            border: 1px solid #c80000;
            border-radius: 2px;
            padding: 4px 25px 5px 10px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 12px;
            pointer-events: none;
            font-family: Poppins-Regular;
            color: #c80000;
            font-size: 14px;
            line-height: 1.4;
            text-align: left;
            visibility: hidden;
            opacity: 0;
            -webkit-transition: opacity 0.4s;
            -o-transition: opacity 0.4s;
            -moz-transition: opacity 0.4s;
            transition: opacity 0.4s;
        }

        .alert-validate::after {
            content: "\f12a";
            font-family: FontAwesome;
            display: block;
            position: absolute;
            color: #c80000;
            font-size: 18px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 18px;
        }

        .alert-validate:hover:before {
            visibility: visible;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .alert-validate::before {
                visibility: visible;
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .wrap-login100 {
                padding-left: 60px;
                padding-right: 60px;
            }

            @media (max-width: 576px) {
                .wrap-login100 {
                    padding-left: 15px;
                    padding-right: 15px;
                }
            }
        }
    </style>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/sobres.jpg');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
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

                        {{-- @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="txt2 bo1 m-l-5">
                            Forgot?
                        </a>
                        @endif --}}
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Contraseña Requerida">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn">
                            Ingresar
                        </button>
                    </div>

                    {{-- <div class="w-full text-center p-t-55">
                        <span class="txt2">
                            Not a member?
                        </span>

                        <a href="#" class="txt2 bo1">
                            Sign up now
                        </a>
                    </div> --}}
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
