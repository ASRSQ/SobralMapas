@extends('layouts.app')

@section('title', 'Mapa de Sobral')

@section('content')

<x-selection-box />
    <div id="map"></div>
<!-- Botão flutuante com dropdown -->
<div class="btn-group dropup" id="floating-button">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Medir
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" id="measure-line">Medir Linha</a></li>
        <li><a class="dropdown-item" href="#" id="measure-area">Medir Área</a></li>
        <li><a class="dropdown-item" href="#" id="stop-drawing">Parar desenho</a></li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item d-flex align-items-center justify-content-between">
            <label for="line-color-picker" class="me-2">Escolher Cor:</label>
            <input type="color" id="line-color-picker" value="#ffcc33">
        </li>
        <li class="dropdown-divider"></li>
        <!-- Botão para apagar todas as geometrias -->
        <li><button class="dropdown-item text-danger" id="clear-drawings">Apagar Tudo</button></li>
    </ul>
</div>







@endsection
