<?php

namespace App\Http\Controllers;

use App\Application\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    public function login(Request $request)
    {
        // Validação dos dados enviados no formulário
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Autentica o usuário
        if (Auth::attempt($credentials)) {
            // Regenera a sessão ao autenticar
            $request->session()->regenerate();

            // Redireciona para o painel principal ou página inicial
            return redirect()->intended('admin');
        }
        // Retorna com erro caso a autenticação falhe
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    public function logout(Request $request)
    {
        // Faz logout do usuário
        Auth::logout();

        // Invalida a sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/acesso-restrito'); // Redireciona para a página de login
    }
}
