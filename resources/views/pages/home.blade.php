@extends('layouts.app')

@section('title', 'Mapa de Sobral')


@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')

<x-selection-box />
<div id="map"></div>

{{-- Componente de ferramenta de medição --}}
<x-ferramenta-medicao/>

<!-- Componente do chat -->
<x-chat/>

@endsection
