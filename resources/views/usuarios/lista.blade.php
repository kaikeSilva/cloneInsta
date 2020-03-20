@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex  justify-content-center ">
        <h1>lista de usuários</h1>
    </div>
    @foreach($users as $user)
    <!--
        retornar uma lista com todos o nome e as fotos de todos os usuarios e um botão seguir
    -->
        <div class="border rounded container d-flex
                    justify-content-between align-items-center mb-3
                    pt-2 pb-2 pl-4 pr-4">
            <div class="">
                <a href="/profile/{{ $user->profile->id }}">
                    <img src="{{ $user->profile->profileImage() }}" height="70px" class="" alt="">
                </a>
            </div>

            <div class="">
                <a class="" href="/profile/{{ $user->profile->id }}">
                    <spam class="font-weight-bold text-dark">
                        {{ $user->username }}
                    </spam>
                </a>
            </div>
        </div>


    @endforeach

    <!--
        MUDAR DEPOIS PARA USERS PAGINATE NA CONTROLLER

        adicionar link para carregar mais posts, é um complemento de paginate() que foi
        usada na controller.

            <div class="row ">
                <div class="col-12 d-flex justify-content-center">
                   
                </div>
            </div>
    -->

    
</div>
@endsection
