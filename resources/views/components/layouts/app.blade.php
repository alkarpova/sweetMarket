<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const link = document.createElement('link');
        link.href = 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap';
        link.rel = 'preload';
        link.as = 'style';
        link.onload = function() { this.onload = null; this.rel = 'stylesheet'; };
        link.crossOrigin = 'anonymous';
        document.head.appendChild(link);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('app.name') }}</title>
</head>
<body class="min-h-screen antialiased bg-neutral-100">
<livewire:components.categories />
<div class="container mx-auto px-4">
    <a href="{{ route('home-page') }}">Home</a>
    @auth

    @else
        <a href="{{ route('login-page') }}">Login</a>
        <a href="{{ route('register-page') }}">Register</a>
    @endauth
</div>
{{ $slot }}
@livewireScripts
</body>
</html>
