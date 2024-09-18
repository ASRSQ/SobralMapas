@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')

@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop