@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 ">
        <!--
            ERRO
                Ao carregar imagem dinamicamente
                Quando a imagem é muito grande retorna 
            "Esta página não está funcionando127.0.0.1 não consegue atender a esta solicitação no momento.
            HTTP ERROR 500"
        -->
            <img src="{{$user->profile->profileImage()}}" class="img-fluid rounded-circle" alt="">
        </div>
        
        <div class="col-9">
            <!-- passar dados para view através da sintaxe mustashe, variavel definida em controller pode ser acessada diretamente -->
            <div class="d-flex justify-content-between align-items-baseline">
                
                <div class="d-flex align-items-center">
                    <div class="h3">{{ $user -> username }}</div>
                    <follow-button follows="{{ $follows }}" userid="{{ $user -> id }}" id="example"/>
                </div>

                <!--
                    diretiva blade para controle de acesso ao link,
                    acessa a policy de update definida para o profile
                -->
                @can('update',$user->profile)
                    <a href="/post/create">Add new post</a>
                @endcan
                
            </div>

            <!--
                diretiva blade para controle de acesso ao link,
                acessa a policy de update definida para o profile
            -->
            @can('update',$user->profile)
                <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan
            
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $followersCount }}</strong> follower</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
                <div class="pr-5"><strong>{{ $postsCount }}</strong> posts</div>
            </div>
            <div class="pt-4"><strong>{{ $user->profile->title }}</strong></div>
                <div>{{$user->profile->description}}</div>
                <div><a href="#" class="link">{{ $user->profile->url}}</a></div>
            </div>
    </div>
    <div class="row pt-4 justifi-content-start">
    <!--        buscar posts pela variavel user e para cada post preencher a imagem
    -->
        @foreach($user->posts as $post)
            <div class="col-4 pt-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{$post->image}}" class="img-fluid" alt="">
                </a>
            </div>
        @endforeach
    </div>

</div>
@endsection
