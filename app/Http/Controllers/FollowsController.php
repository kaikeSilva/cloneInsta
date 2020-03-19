<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
/*
    para criar uma nova controller pelo artisan
    executar comando: php artisan make:controller (nome da controller)
*/
class FollowsController extends Controller
{
    //controle para que seja concedido acesso apenas se o usuario estiver autenticado
    public function __construct()
    {
        $this->middleware('auth');
    }

    //função para guardar os usúarios que seguir
    //O parâmetro $user não é o usuário autenticado e sim o que se deseja seguir
    //esta função cria a relação entre o usuario autenticado (auth()->user()) que clicou no botão e
    //o perfil ($user->profile) do usuário que teve o botão de seguir clicado 
    public function store(User $user) 
    {
        //a função toggle faz a ligação e tambem desliga
        //retorna um array contendo doias arrays attached (seguindo) detached(deixados de seguir)
        return auth()->user()->following()->toggle($user->profile);
    }
}
