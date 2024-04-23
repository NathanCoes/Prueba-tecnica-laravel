<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nova | @yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset("css/all.min.css") }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset("css/OverlayScrollbars.min.css") }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset("css/adminlte.min.css") }}">
        <!-- jQuery -->
        <script src=" {{ asset("js/jquery.js") }} "></script>
        @yield('extraCSS')
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

