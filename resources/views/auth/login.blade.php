{{-- Login Page View --}}
@extends('layouts.app')

@section('content')

    <div class="page-content ">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex align-items-center walpic mt-4">

                    <div class="col-md-7 col-12 offset-2 mt-5">
                        <div class="rounded-0 mb-0">
                            <div class="row">

                                <div class="col-md-4 offset-8  border-top  border-top-width-3 border-bottom border-bottom-main  border-bottom-width-3 border-top-main rounded-0"
                                    style="background: #ffffffd3">
                                    {{--  Logo --}}
                                    <div class="col-6 mx-auto mb-0   mt-2">
                                        <img src="{{ asset('img/erp-01.png') }}" class="img-fluid" alt="logo here"
                                            alt="logo">

                                    </div>
                                    {{-- ./ --}}

                                    <form method="POST" action="{{ route('login') }}" id="login_form">
                                        @csrf
                                        <!-- Email Address -->

                                        <div class="mb-3">
                                            <label class="form-label text-main font-weight-bold">Email</label>

                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input
                                                    class="form-control @if ($errors->has('email')) is-invalid @endif"
                                                    name="email" type="text" id="email" required
                                                    placeholder="Email" autocomplete="off">

                                                <div class="form-control-feedback-icon">
                                                    <i toggle="#password-field" class="ph-user-circle text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Password -->

                                        <div class="mb-2">
                                            <label class="form-label text-main">Password</label>

                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input type="password" id="password"
                                                    class="form-control @if ($errors->has('password')) is-invalid @endif"
                                                    placeholder="password" name="password" required autocomplete="off">

                                                <div class="form-control-feedback-icon" id="showPass">
                                                    <i class="ph-eye-closed text-muted toggle-password"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="block ">
                                            <label for="remember_me" class="inline-flex items-center">
                                                {{-- <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember"> --}}
                                                {{-- <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span> --}}
                                            </label>
                                        </div>

                                        {{-- displaying all the errors  --}}
                                        @if ($errors->any())
                                            <div class="btn disabled btn-danger col-12 mb-2">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- Alert Messages --}}
                                        @if (session('msg'))
                                            <div class="alert alert-success mt-1 mb-1 col-12 mx-auto" role="alert">
                                                {{ session('msg') }}
                                            </div>
                                        @endif
                                        {{-- / --}}

                                        <div class="flex items-center justify-end mt-4">
                                            <x-primary-button class="btn btn-dark text-dark btn-block col-12 mb-1"
                                                id="login">
                                                {{ __('Log in') }}
                                            </x-primary-button>
                                            <br>
                                            @if (Route::has('password.request'))
                                                {{-- <a class="underline text-sm mt-1 text-brand-secondary  text-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 float-end" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a> --}}
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var togglePasswords = document.querySelectorAll(".toggle-password");

            togglePasswords.forEach(function(togglePassword) {
                togglePassword.addEventListener("click", function() {
                    togglePassword.classList.toggle("ph-eye");
                    togglePassword.classList.toggle("ph-eye-closed");

                    var input = document.getElementById("password");
                    // var input = document.querySelector(targetInputId);

                    if (input.getAttribute("type") === "password") {
                        input.setAttribute("type", "text");
                    } else {
                        input.setAttribute("type", "password");
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".alert").slideDown(300).delay(2000).slideUp(300);
        });
    </script>

    {{-- For Submit Allocation --}}
    <script>
        $("#login_form").submit(function(e) {
            // e.preventDefault();
            $("#login").html("<i class='ph-spinner spinner me-2'></i> Loging in ...").addClass('disabled').delay(
                2000).max(2000);

        });
    </script>


<script>
    // Trigger an installation prompt to the user
    if ('serviceWorker' in navigator && 'beforeinstallprompt' in window) {
        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            const installPrompt = event;
            const installButton = document.createElement('button');
            installButton.textContent = 'Install App';
            installButton.classList.add('btn', 'btn-main', 'w-100', 'py-2', 'mb-3');
            installButton.addEventListener('click', () => {
                installPrompt.prompt();
                installPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    installPrompt = null;
                });
            });
            document.querySelector('.login-card .card-body').appendChild(installButton);
        });
    }
</script>
@endsection
