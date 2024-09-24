@extends('layouts.app')

@section('title', 'Mapa de Sobral')

@section('content')

<div id="selection-box">

    <div id="drag-handle">
        <span>
            Arraste
        </span>
        <span>
            Imprimir Área
        </span>
        <span id="sel-box-dim">

        </span>
    </div>

</div>
    <div id="map"></div>
@endsection
