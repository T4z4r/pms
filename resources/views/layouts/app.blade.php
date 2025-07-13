<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', ' Fléx ERP') }}</title>

    <link rel="manifest" href="manifest.json">

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="{{ asset('assets/date-picker/daterangepicker.css') }}" rel="stylesheet">

    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}


    <script src="{{ asset('assets/js/configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/notifications/noty.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/notifications/sweet_alert.min.js') }}"></script>


    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/pages/extra_noty.js') }}"></script>
    <script src="{{ asset('assets/js/pages/extra_sweetalert.js') }}"></script>


    <style>
        .btn-main {
            width: 130px;
            height: 40px;
            color: #fff;
            border-radius: 5px;
            padding: 10px 25px;
            font-family: 'Lato', sans-serif;
            font-weight: 500;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, .5),
                7px 7px 20px 0px rgba(0, 0, 0, .1),
                4px 4px 5px 0px rgba(0, 0, 0, .1);
            outline: none;
        }

        .btn-main {
            border: none;
            background: rgb(251, 33, 117);
            background: linear-gradient(0deg, rgba(251, 33, 117, 1) 0%, rgba(234, 76, 137, 1) 100%);
            color: #fff;
            overflow: hidden;
        }

        .btn-main:hover {
            text-decoration: none;
            color: #fff;
        }

        .btn-main:before {
            position: absolute;
            content: '';
            display: inline-block;
            top: -180px;
            left: 0;
            width: 30px;
            height: 100%;
            background-color: #fff;
            animation: shiny-btn1 3s ease-in-out infinite;
        }

        .btn-main:hover {
            opacity: .7;
        }

        .btn-main:active {
            box-shadow: 4px 4px 6px 0 rgba(255, 255, 255, .3),
                -4px -4px 6px 0 rgba(116, 125, 136, .2),
                inset -4px -4px 6px 0 rgba(255, 255, 255, .2),
                inset 4px 4px 6px 0 rgba(0, 0, 0, .2);
        }

        @-webkit-keyframes shiny-btn1 {
            0% {
                -webkit-transform: scale(0) rotate(45deg);
                opacity: 0;
            }

            80% {
                -webkit-transform: scale(0) rotate(45deg);
                opacity: 0.5;
            }

            81% {
                -webkit-transform: scale(4) rotate(45deg);
                opacity: 1;
            }

            100% {
                -webkit-transform: scale(50) rotate(45deg);
                opacity: 0;
            }
        }



        .login-cover {


         background-image: url('{{ asset('assets/images/flex_erp_new_bg.png') }}');

            min-height: 500px;
            /* background-color: #cccccc; */
            /* background-position:center; */
            background-repeat: no-repeat;
            background-size: cover;
            /* background-attachment: fixed; */
        }
    </style>
</head>




<body class=" login-cover" >

    <div id="app" >


        <main class="py-4" >
            @yield('content')
        </main>
    </div>
</body>

</html>
