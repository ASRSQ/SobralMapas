@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Layer') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('layers.update', $layer->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mt-2">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $layer->name }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-2">
                            <label for="layer" class="col-md-4 col-form-label text-md-right">{{ __('Layer') }}</label>

                            <div class="col-md-6">
                                <select id="layers" class="form-control @error('layer') is-invalid @enderror" name="layer" required>
                                    <option value="">Select Layer</option>
                                    <option value="{{ $layer->layer }}" selected>{{ $layer->layer }}</option>
                                </select>

                                @error('layer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mt-2">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ $layer->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Layer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="module">
    import { layers } from '{{ asset('js/layers.js') }}';
    $(document).ready(function() {
        // Certifique-se de que #layers está apontando para o elemento correto
        var $layersSelect = $('#layers');

        // Verifique se #layers foi encontrado no DOM
        if ($layersSelect.length) {
            // Adicione as opções de camada ao elemento select usando os dados de layers.js
            layers.forEach(function(layerOption) {
                $layersSelect.append($('<option>', {
                    value: layerOption,
                    text: layerOption,
                    selected: layerOption === "{{ $layer->layer }}" // Seleciona a opção correspondente à camada atual
                }));
            });

            // Inicialize o Select2 para o elemento select
            $layersSelect.select2({
                placeholder: 'Select Layer',
                tags: true,
                tokenSeparators: [',', ' '],
                // Outras opções do Select2...
            });
        }
    });
</script>

@endsection
