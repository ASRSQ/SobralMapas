@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Camadas Disponíveis no GeoServer</h1>

        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome da Camada</th>
                        <th>Título da Camada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($layersData as $layer)
                        <tr>
                            <td>{{ $layer['name'] }}</td>
                            <td>{{ $layer['title'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
