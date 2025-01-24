@extends('adminlte::page')

@section('title', 'Gerenciar Usuários')

@section('content_header')
    <h1>Gerenciamento de Usuários</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Formulário de criação de usuário -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Novo Usuário</h3>
                </div>
                <div class="card-body">
                    <form id="user-form" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="login">Login</label>
                            <input type="text" class="form-control" id="login" name="login" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="profile">Perfil</label>
                            <select class="form-control" id="profile" name="profile_id" required>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->getId() }}">{{ $profile->getNome() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Criar Usuário</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de usuários -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Usuários</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($users as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center" id="user-{{ $user->getId() }}">
                                <span class="user-name" data-id="{{ $user->getId() }}" data-name="{{ $user->getName() }}" data-email="{{ $user->getEmail() }}" data-login="{{ $user->getLogin() }}" data-profile="{{ $user->getProfileId() }}">
                                    {{ $user->getName() }} 
                                </span>
                                <div>
                                    <button class="btn btn-warning btn-sm mx-1" onclick="editUser({{ $user->getId() }})">Editar</button>
                                    <form action="{{ route('admin.users.destroy', $user->getId()) }}" method="POST" style="display:inline;">
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

<!-- Modal de edição -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-user-form" method="POST" action="{{ route('admin.users.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit-name">Nome</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-email">E-mail</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-login">Login</label>
                        <input type="text" class="form-control" id="edit-login" name="login" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-password">Nova Senha (deixe em branco para não alterar)</label>
                        <input type="password" class="form-control" id="edit-password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="edit-profile">Perfil</label>
                        <select class="form-control" id="edit-profile" name="profile_id" required>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->getId() }}">{{ $profile->getNome() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="edit-user-id" name="user_id">
                    <button type="submit" class="btn btn-primary mt-3">Atualizar Usuário</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
   function editUser(userId) {
    const userElement = document.querySelector(`#user-${userId} .user-name`);
    const formAction = `{{ route('admin.users.update', ':id') }}`.replace(':id', userId);

    document.getElementById('edit-name').value = userElement.getAttribute('data-name');
    document.getElementById('edit-email').value = userElement.getAttribute('data-email');
    document.getElementById('edit-login').value = userElement.getAttribute('data-login');
    document.getElementById('edit-profile').value = userElement.getAttribute('data-profile');

    // Limpa o campo de senha
    document.getElementById('edit-password').value = '';

    document.getElementById('edit-user-form').action = formAction;
    document.getElementById('edit-user-id').value = userId;

    $('#editUserModal').modal('show');
}

</script>
@endsection
