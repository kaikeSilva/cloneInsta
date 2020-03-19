<?php

namespace App\Http\Controllers;

//para manipular imagens foi adicionado pelo composer a dependencia:
//composer require intervention/image
//para que a classe image usada abaixo referencie corretamente a classe da dependencia 
//foi adicionada essa namespace:
/*
    Seguiu-se o erro: GD Library extension not available with this PHP installation.
    foi preciso habilitar gd2 extension em php.ini, após reiniciar o server funcionou
*/
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
//comando funciona como um alias para caminho
//ao referenciar User ele encontra baseado nesse caminho
use App\User;

//namespace para suporte à caching
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{

    //retornar a view com os dados do usuário que foi passada na url
    //findOrFail desvia para a pagina 404 se não encontrar
    //convenção para criação de nomes:
    //nome do metodo deve ser o mesmo nome da view que ele retorna
    //nome da pasta que contem a view deve ser o mesmo da controller
    public function index($user)
    {
        //função dd() serve para debugar funciona parecido com echo()
        //dd($user);
        $user = User::findOrFail($user);


        //cache remember permite otimizar a aplicação guardando em cache alguns dados
        //assim ao buscar precisar do dado não há necessidade de buscar no banco (cache hit)
        //tem quatro argumentos:
        //1 - uma chave para identificar o valor
        //2 - tempo que o valor vai ficar guardado em cache
        //3 - função de callback, que recupera o valor do cache quando este expirar
        $followersCount = Cache::remember(
            'count.followers'.$user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
            }
        ); 
        $followingCount = Cache::remember(
            'count.following'.$user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->following->count();
            }
        ); 
        $postsCount = Cache::remember(
            'count.post'.$user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
            }
        ); 

        //verificar se o usuário esta autenticado
        //e então verificar se o usuário passado no parametro esta entre os que ele segue
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        return view('/profiles/index', [
            'user' => $user,
            'follows' => $follows,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'postsCount' => $postsCount
        ]);
    }

    //se o argumento da função tem o mesmo nome da variavel na colocada na rota show
    //é possivel fazer o preenchimento da variavel automaticamente com o objeto postagem
    //nome do recurso: route model binding
    //adicionar \App\User antes da variavel, aqui foi adicionado apenas User pois a namespace use App/User
    //foi declarada acima
    //esse recurso tambem direciona para 404 caso não exista o usuário
    public function edit(User $user)
    {
        //adicionar policy para controlar o acesso a view de editar o perfil
        $this->authorize('update',$user->profile);

        return view('profiles.edit',compact('user'));
    }

    /*
        ATUALIZAR DADOS DO PROFILE DO USUÁRIO
    */
    //se o argumento da função tem o mesmo nome da variavel na colocada na rota update
    //é possivel fazer o preenchimento da variavel automaticamente com o objeto user
    //nome do recurso: route model binding
    //adicionar \App\User antes da variavel, aqui foi adicionado apenas User pois a namespace use App/User
    //foi declarada acima
    //esse recurso tambem direciona para 404
    public function update(User $user)
    {
        //adicionar policy para controlar o acesso a view de editar o perfil
        $this->authorize('update',$user->profile);

        //validação
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        

        //Tratamento para salvar a imagem em storage caso o usuario faça o update
        if(request('image')) {
             /*
               TRATAMENTO PARA SALVAR IMAGEM
            */
            //salvar a imagem em uma pasta e levar o caminho dessa pasta para a tabela de posts
            //Usar função store([nome do diretorio para salvar], [driver que devera salvar])
            //o driver no caso de local storage é 'public'
            //Para acessar a imagem pela url é preciso fazer o link do diretorio storage com o diretorio publico da aplicação
            //o comando do artisan para fazer esse link é php artisan storage:link
            //imagem não fazia upload, mudar upload_max_size e post_max_size em php.ini
            $imagepath = request('image')->store('storage','public');
            

            /*
                MANIPULAÇÃO DE IMAGEM VIA DEPENDENCIA EXTERNA
            */
            //tornar a imagem quadrada 1100x1100px
            $image = Image::make(public_path("storage/{$imagepath}"))->fit(1100,1100);
            $image->save();

            $imageArray = ['image' => $imagepath];
        }

        //substituir a imagem do upload pelo caminho dela e
        //atualizar atraves da relação entre profile e user pelo usuário autenticado
        /*
            o metodo array_merge sobreescreve os dados do primeiro array caso haja um 
            indice de memo nome
        */
        auth()->user()->profile->update(array_merge(
            $data,
            //concertar erro que não existe imagePath
            //se não houver nenhuma imagem para atualizar faz o merge com array vazio
            $imageArray ?? [] 
        ));


        return redirect("/profile/{$user->id}");

        
    }
}
