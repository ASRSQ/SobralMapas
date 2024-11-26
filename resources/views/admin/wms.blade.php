@extends('adminlte::page')

@section('title', 'Adicionar Link WMS')

@section('adminlte::meta_tags')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content_header')
    <h1>Adicionar Link WMS</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Formulário para adicionar o link WMS -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Adicionar Link WMS</h3>
                </div>
                <div class="card-body">
                    <form id="wms-form" action="{{ route('admin.wms.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="url">URL do WMS</label>
                            <input type="url" class="form-control" id="url" name="url" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" id="submit-btn">Adicionar WMS</button>
                    </form>

                    <!-- Animação de carregamento -->
                    <div id="loading" class="d-none">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Carregando...</span>
                        </div>
                        <p>Carregando dados...</p>
                    </div>

                    <!-- Mensagens de sucesso ou erro -->
                    <div id="success-alert" class="alert alert-success d-none"></div>
                    <div id="error-alert" class="alert alert-danger d-none"></div>
                </div>
            </div>
        </div>

        <!-- Exibir os WMS cadastrados -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">WMS Cadastrados</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group" id="wms-list">
                        @foreach($wmsLinks as $link)
                        <li class="list-group-item">
                            <span>{{ $link->name }} ({{ $link->url }})</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#wms-form').on('submit', function (e) {
            e.preventDefault();

            // Mostrar a animação de carregamento
            $('#loading').removeClass('d-none');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#loading').addClass('d-none');
                    $('#success-alert').removeClass('d-none').text(response.message);
                    $('#wms-list').append('<li class="list-group-item">' + response.wms_link.name + ' (' + response.wms_link.url + ')</li>');
                    $('#wms-form')[0].reset();
                },
                error: function(xhr) {
                    $('#loading').addClass('d-none');
                    $('#error-alert').removeClass('d-none').text('Ocorreu um erro ao adicionar o WMS.');
                }
            });
        });
    });
</script>
@endsection
