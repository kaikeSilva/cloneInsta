<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsuariosController extends Controller
{
    //Levar para uma página contendo uma lista com todos os usuários
    public function index()
    {
        //buscar todos os usuários e listar na tela
        $users = User::all();

        //verificar se o usuário esta autenticado
        //e então verificar se o usuário passado no parametro esta entre os que ele segue
        $follows = (auth()->user()) ? auth()->user()->following->contains(auth()->user()->id) : false;

        return view('usuarios.lista',compact('users','follows'));
    }
}

