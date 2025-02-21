@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 22rem; border-color: #0086de;">
        <div class="card-body">
            <h5 class="card-title text-center">Acesse o sistema</h5>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Senha" required>
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="background-color: #0086de; border-color: #0086de;">
                    Entrar
                </button>
            </form>
            @if ($errors->any())
                <div class="mt-3 alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
             @endif
        </div>
    </div>
</div>
.
@endsection
