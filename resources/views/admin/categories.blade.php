@extends('adminlte::page')

@section('title', 'Relatórios de Acessos e Interesses')

@section('adminlte::meta_tags')
    <!-- Adiciona o CSRF Token no head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content_header')
    <h1>Categorias</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Card de criação de categoria -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Nova Categoria</h3>
                </div>
                <div class="card-body">
                    <!-- Formulário para criar ou editar categoria -->
                    <form id="category-form" action="{{ route('categories.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome da Categoria</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Criar Categoria</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card de lista de categorias -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Categorias</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center" id="category-{{ $category->getId() }}">
                                <!-- Nome da Categoria, clicável para edição -->
                                <span class="category-name" data-id="{{ $category->getId() }}" data-name="{{ $category->getName() }}">
                                    {{ $category->getName() }}
                                </span>

                                <!-- Botões de Ação: Editar e Excluir -->
                                <div>
                                    <!-- Botão de editar -->
                                    <button class="btn btn-warning btn-sm mx-1" onclick="editCategory({{ $category->getId() }})">Editar</button>

                                    <!-- Formulário de exclusão -->
                                    <form action="{{ route('categories.delete', $category->getId()) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </div>
                            </li>
                            <!-- Subcategorias da Categoria -->
                            <ul>
                                @foreach($category->getSubcategories() as $subcategory)
                                    <li>{{ $subcategory->getName() }}</li>
                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para edição -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário de edição de categoria -->
                <form id="edit-category-form" method="POST" action="{{ route('categories.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit-name">Nome da Categoria</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <input type="hidden" id="edit-category-id" name="category_id">
                    <button type="submit" class="btn btn-primary mt-3">Atualizar Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para editar categoria ao clicar no botão Editar
    function editCategory(categoryId) {
        // Obtém os dados da categoria
        const categoryName = document.querySelector(`#category-${categoryId} .category-name`).getAttribute('data-name');
        const formAction = `{{ route('categories.update', ':id') }}`.replace(':id', categoryId);
        
        // Preenche os campos do formulário no modal de edição
        document.getElementById('edit-name').value = categoryName;
        document.getElementById('edit-category-id').value = categoryId;
        
        // Atualiza a ação do formulário de edição
        document.getElementById('edit-category-form').action = formAction;
        
        // Abre o modal de edição
        $('#editCategoryModal').modal('show');
    }

    // Função para enviar o formulário de edição via AJAX
    document.getElementById('edit-category-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio tradicional do formulário

        const categoryId = document.getElementById('edit-category-id').value;
        const formAction = this.action;
        const formData = new FormData(this);

        // Envia a requisição AJAX
        fetch(formAction, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            // Verifica se a atualização foi bem-sucedida
            if (data.success) {
                // Exibe a mensagem de sucesso
                alert(data.message);
                
                // Atualiza o nome da categoria na lista sem recarregar a página
                document.querySelector(`#category-${categoryId} .category-name`).textContent = data.name;

                // Fecha o modal
                $('#editCategoryModal').modal('hide');
            } else {
                // Exibe a mensagem de erro
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Erro inesperado:", error);
            alert("Ocorreu um erro inesperado ao atualizar a categoria.");
        });
    });
</script>


@endsection
