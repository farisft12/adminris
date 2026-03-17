<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Adminris') }} - @yield('title', 'Login')</title>
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-900 font-sans text-slate-100 antialiased" style="font-family: system-ui, ui-sans-serif, sans-serif;">
    @yield('content')
</body>
</html>
