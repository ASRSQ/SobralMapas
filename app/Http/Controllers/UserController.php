<?php

namespace App\Http\Controllers;

use App\Application\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Lista todos os usuários
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users', [
            'users' => $users,
            'profiles' => $this->userService->getAllProfiles() // Obtém perfis para popular o formulário
        ]);
    }

    /**
     * Cria um novo usuário
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'login' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'profile_id' => 'required|exists:profiles,id',
        ]);

        $user = $this->userService->createUser(
            $validated['name'],
            $validated['email'],
            $validated['login'],
            $validated['password'],
            $validated['profile_id']
        );

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Atualiza um usuário existente
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'login' => 'required|string|unique:users,login,' . $id,
            'password' => 'nullable|string|min:6', // Senha é opcional
            'profile_id' => 'required|exists:profiles,id',
        ]);
    
        $this->userService->updateUser(
            $id,
            $validated['name'],
            $validated['email'],
            $validated['login'],
            $validated['password'], // Pode ser null
            $validated['profile_id']
        );
    
        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
    

    /**
     * Exclui um usuário
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
