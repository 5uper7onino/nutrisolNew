<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    <style>
        #app { /* .login-background { */
        background-image: url('{{asset('img/bg_alimentaria.webp')}}');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        align-items: center;
        background-color: transparent;
        border-radius: 15px;
        }

    </style>        
    </head>
    <body>
        <div id="app" class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
