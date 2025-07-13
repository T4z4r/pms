<link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
<link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

@stack('head-css')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link href=" https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/css/icons.min.css " rel="stylesheet">


{{-- <script src="{{ asset('assets/js/configurator.js') }}"></script> --}}
<script src="{{asset('assets/demo/demo_configurator.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

	<!-- Theme JS files -->
	<script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

{{-- <script src="{{ asset('assets/js/jquery/jquery1.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>


<script src="{{ asset('assets/js/components/notifications/noty.min.js') }}"></script>
<script src="{{ asset('assets/js/components/notifications/sweet_alert.min.js') }}"></script>

@stack('head-script')
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/pages/extra_noty.js') }}"></script>
<script src="{{ asset('assets/js/pages/extra_sweetalert.js') }}"></script>

@stack('head-scriptTwo')

<script src=" https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/index.min.js"></script>
<script src="{{ asset('assets/loader.js') }}"></script>
{{-- <script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            // Disable the buttons and show the spinner
            $("button[type='submit']").html("<i class='ph-spinner spinner me-2'></i> Saving ...").addClass('disabled');
        });
    });
</script> --}}

@php
    use App\Models\BrandSetting;
    $brandSetting = BrandSetting::firstOrCreate();
@endphp

<style>
     :root {
        /* previous bank ABC #00204e */
        --primary-color: {{ $brandSetting->primary_color }} !important;
        /* previous bank ABC #f0ab00 */
        --secondary-color: {{ $brandSetting->secondary_color }}  !important;
        /* previous bankABC #f0ab00 */
        --hover-color: {{ $brandSetting->hover_color }}  !important;

        /* previous bankABC ##f7c341 */
        --hover-color-two: {{ $brandSetting->hover_color_two }}  !important;
        /* Add more variables for other colors as needed */

        /* previous bankABC ##f7c341 */
        --loader-colorone: {{ $brandSetting->loader_color_one }}  !important;

        /* previous bankABC ##f7c341 */
        --loader-colortwo: {{ $brandSetting->loader_color_two }}  !important;

        /* previous bankABC ##f7c341 */
        --loader-colorthree: {{ $brandSetting->loader_color_three }}  !important;

        /* previous bankABC ##f7c341 */
        --loader-colorfor: {{ $brandSetting->loader_color_four }};

        /* previous bankABC ##f7c341 */
        --loader-colorfive: {{ $brandSetting->loader_color_five }};

        /* previous bankABC ##f7c341 */
        --loader-colorsix: {{ $brandSetting->loader_color_six }};

        --hover-text-color: {{ $brandSetting->text_hover_color }};
            /* Add more variables for other colors as needed */
            --text-color: {{ $brandSetting->text_color }};
            /* Add more variables for other colors as needed */
    }
</style>
{{-- Custom --}}
<style>
    .pre-styled {
        font-size: 14px;
    }

    #myDiv {
        display: none;
        /* Hide the div by default */
    }

    .visible {
        display: block;
        /* Show the div when the 'visible' class is applied */
    }

    #whatsapp-button-container {
        position: fixed;
        bottom: 20px;
        /* Adjust this value to control the distance from the bottom */
        right: 20px;
        /* Adjust this value to control the distance from the right */
        z-index: 999;
        /* Adjust this value if needed to control the stacking order */
    }



    .request__spinner {
        /* background: red; */
        /* position: absolute;
            z-index: 99999;
            left: 50%;
            top: 50%;
            display: none;
            width: 50px;
            height: 50px;
            margin: 20px auto;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-left: 5px solid #003366;
            border-right: 5px solid #003366;
            animation: request__spinner 1s linear infinite forwards;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -o-border-radius: 50%;
            -ms-border-radius: 50%;
            border-radius: 50%; */

        position: absolute;
        top: calc(50% - 15px);
        left: calc(50% - 15px);
        width: 40px;
        height: 40px;
        border: 4px solid #a9a9a9;
        border-top-color: #000;
        border-radius: 30px;
        animation: spin 1s linear infinite;
        display: none;
        z-index: 1000;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    body {
        /* background-image: url('{{ asset('img/bg2.png') }}'); */
        background-image: url('{{ $brandSetting !=null && $brandSetting->body_background != null ? asset("storage/" . $brandSetting->body_background) : asset("img/bg2.png") }}');
        /* background-color: #f1f1f1; */
        /* background-color: #ffff; */
        /* background: cover; */
        background-position: center;
        background-repeat: no-repeat;
    }

    /* .card {
        background-color: transparent !important;
    } */


    .loader {
        height: 100vh;
        width: 100vw;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        background: #ffffff;
        z-index: 99;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .removed {
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .loader--dot {
        animation-name: loader;
        animation-timing-function: ease-in-out;
        animation-duration: 3s;
        animation-iteration-count: infinite;
        height: 20px;
        width: 20px;
        border-radius: 100%;
        background-color: black;
        position: absolute;
        border: 2px solid white;
    }

    .loader--dot:first-child {
        background-color: var(--loader-colorone, #00204e);
        animation-delay: 0.5s;
    }

    .loader--dot:nth-child(2) {
        background-color: var(--loader-colortwo, #f58646);
        animation-delay: 0.4s;
    }

    .loader--dot:nth-child(3) {
        background-color: var(--loader-colorthree, #da2128);
        animation-delay: 0.3s;
    }

    .loader--dot:nth-child(4) {
        background-color: var(--loader-colorfour, #00204e);
        animation-delay: 0.2s;
    }

    .loader--dot:nth-child(5) {
        background-color: var(--loader-colorfive, #37719f);
        animation-delay: 0.1s;
    }

    .loader--dot:nth-child(6) {
        background-color: var(--loader-colorsix, #818386);
        animation-delay: 0s;
    }

    .loader--text {
        position: absolute;
        top: 200%;
        left: 0;
        right: 0;
        width: 10rem;
        margin: auto;
    }

    .loader--text:after {
        content: "Loading ...";
        font-weight: bold;
        animation-name: loading-text;
        animation-duration: 3s;
        animation-iteration-count: infinite;
    }

    @keyframes loader {
        15% {
            transform: translateX(0);
        }

        45% {
            transform: translateX(230px);
        }

        65% {
            transform: translateX(230px);
        }

        95% {
            transform: translateX(0);
        }
    }

    @keyframes loading-text {
        0% {
            content: "Loading";
        }

        25% {
            content: "Loading .";
        }

        50% {
            content: "Loading  ..";
        }

        75% {
            content: "Loading  ...";
        }
    }
</style>
