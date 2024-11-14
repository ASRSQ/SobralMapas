@extends('adminlte::page')

@section('title', 'Subcategorias')

@section('adminlte::meta_tags')
    <!-- Adiciona o CSRF Token no head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content_header')
    <h1>Subcategorias</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Card de criação de subcategoria -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Nova Subcategoria</h3>
                </div>
                <div class="card-body">
                    <!-- Formulário para criar subcategoria -->
                    <form id="subcategory-form" action="{{ route('subcategories.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome da Subcategoria</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Categoria</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Selecione a Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->getId() }}">{{ $category->getName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Criar Subcategoria</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card de lista de subcategorias -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Subcategorias</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                    @foreach($subcategories as $subcategory)
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="subcategory-{{ $subcategory->getId() }}">
                        <span class="subcategory-name" data-id="{{ $subcategory->getId() }}" data-name="{{ $subcategory->getName() }}" data-category-id="{{ $subcategory->getCategoryId() }}">
                            {{ $subcategory->getName() }} ({{ $subcategory->getCategory()->getName() }}) <!-- Use o método getCategory() -->
                        </span>
                        <div>
                            <button class="btn btn-warning btn-sm mx-1" onclick="editSubcategory({{ $subcategory->getId() }})">Editar</button>
                            <!-- Formulário de exclusão -->
                            <form action="{{ route('subcategories.delete', $subcategory->getId()) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </li>
                @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para edição -->
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubcategoryModalLabel">Editar Subcategoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alerta para exibir mensagens de erro -->
                <div id="error-alert" class="alert alert-danger d-none"></div>
                <div id="success-alert" class="alert alert-success d-none"></div>

                <!-- Formulário de edição de subcategoria -->
                <form id="edit-subcategory-form" method="POST" action="{{ route('subcategories.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit-name">Nome da Subcategoria</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-category_id">Categoria</label>
                        <select class="form-control" id="edit-category_id" name="category_id" required>
                            <option value="">Selecione a Categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->getId() }}">{{ $category->getName() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="edit-subcategory-id" name="subcategory_id">
                    <button type="submit" class="btn btn-primary mt-3">Atualizar Subcategoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para editar subcategoria ao clicar no botão Editar
    function editSubcategory(subcategoryId) {
        const subcategoryName = document.querySelector(`#subcategory-${subcategoryId} .subcategory-name`).getAttribute('data-name');
        const categoryId = document.querySelector(`#subcategory-${subcategoryId} .subcategory-name`).getAttribute('data-category-id');
        const formAction = `{{ route('subcategories.update', ':id') }}`.replace(':id', subcategoryId);

        document.getElementById('edit-name').value = subcategoryName;
        document.getElementById('edit-category_id').value = categoryId;
        document.getElementById('edit-subcategory-id').value = subcategoryId;

        document.getElementById('edit-subcategory-form').action = formAction;

        $('#editSubcategoryModal').modal('show');
    }

    // Função para enviar o formulário de edição via AJAX
    document.getElementById('edit-subcategory-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const subcategoryId = document.getElementById('edit-subcategory-id').value;
        const formAction = this.action;
        const formData = new FormData(this);
        fetch(formAction, {
    method: 'POST', // Ou 'PUT', conforme sua configuração de rota
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
})
.then(response => {
    // Verifique se o conteúdo é JSON
    const contentType = response.headers.get("content-type");
    if (contentType && contentType.includes("application/json")) {
        return response.json();
    } else {
        return response.text().then(text => { throw new Error("Resposta inesperada do servidor: " + text); });
    }
})
.then(data => {
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');

    if (data.success) {
        successAlert.classList.remove('d-none');
        successAlert.textContent = data.message;

        document.querySelector(`#subcategory-${subcategoryId} .subcategory-name`).textContent = `${data.name} (${data.category_name})`;
        $('#editSubcategoryModal').modal('hide');
    } else {
        errorAlert.classList.remove('d-none');
        errorAlert.textContent = data.message;
    }
})
.catch(error => {
    console.error("Erro inesperado:", error.message);
    alert("Ocorreu um erro inesperado ao atualizar a subcategoria: " + error.message);
});

    });
</script>
@endsection
