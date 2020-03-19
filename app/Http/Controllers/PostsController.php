<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//para manipular imagens foi adicionado pelo composer a dependencia:
//composer require intervention/image
//para que a classe image usada abaixo referencie corretamente a classe da dependencia 
//foi adicionada essa namespace:
/*
    Seguiu-se o erro: GD Library extension not available with this PHP installation.
    foi preciso habilitar gd2 extension em php.ini, após reiniciar o server funcionou
*/
use Intervention\Image\Facades\Image;
use App\Post;

class PostsController extends Controller
{

    //controle de autenticação
    //criar construtor da controller que verifica authenticação
    public function __construct () 
    {
        //se não houver autenticação é mandado para a página de login
        $this->middleware('auth');
    }

    //pagina principál das postagens irá mostrar todas as postagens dos usúarios que
    //o usuario autenticado esta seguindo
    public function index() {

        //metodo pluck() cria um array com o atributo passado como parâmetro
        //$user contem id's dos usuários que esta seguindo
        $users = auth()->user()->following()->pluck('profiles.user_id');

        //na tabela posts buscar pelos posts que tem id de usuários que estão sendo seguidos
        //latest() ordena pelo mais recente
        //$posts = Post::whereIn('user_id',$users)->latest()->get();
        //em vez de usar get foi usado paginate(), este recebe o numero de elementos de post que
        //devem ser mostrados por vez, e adiciona a funcionalidade link para ser usada na view para
        //carregar mais posts.
        //limit 1 problem, quando carregava o post não buscava os usuários junto,
        //o problema é que toda vez que era preciso carregar uma dado do usuário pela relação
        //ele fazia uma nova query para busca-lo, 1 de cada vez, assim se há dez post são 10 query's
        //with('user') carrega os usuários na primeira busca por posts e elimina esse problema.
        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(1);

        return view('posts.index',compact('posts'));
    }

    //direcionar para página de criação
    public function create() 
    {
        return view('posts.create');
    }

    //metodo para guardar novo registro
    public function store() 
    {

        /*
                VALIDAÇÃO DOS DADOS
        */
        //dd(request()->all());
        //a função validate possui uma documentação completa e é possivel adicionar diversos parametros para validação
        $data = request()->validate([
            'caption' => 'required',
            'image' => 'required|image',
        ]);


        /*
               TRATAMENTO PARA SALVAR IMAGEM
        */
        //salvar a imagem em uma pasta e levar o caminho dessa pasta para a tabela de posts
        //Usar função store([nome do diretorio para salvar], [driver que devera salvar])
        //o driver no caso de local storage é 'public'
        //Para acessar a imagem pela url é preciso fazer o link do diretorio storage com o diretorio publico da aplicação
        //o comando do artisan para fazer esse link é php artisan storage:link
        //imagem não fazia upload, mudar upload_max_size e post_max_size em php.ini
        $imagepath = request('image')->store('uploads','public');
        

        /*
               MANIPULAÇÃO DE IMAGEM VIA DEPENDENCIA EXTERNA
        */
        //tornar a imagem quadrada 1200x1200px
        $image = Image::make(public_path("storage/{$imagepath}"))->fit(1200,1200);
        $image->save();


        /*
                TRATAMENTO PARA RELAÇÃO ENTRE A TABELA USER E TABELA POSTS
        */
        //criar novo registro
        //Existe uma relação de post e user, adicionar a chave estrangeira de user na criação
        //isso é feito chamando o metodo create a parte do usuario autenticado
        //passar os parâmetros de armazenagem separados
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagepath,     
        ]);

        /*
                REDIRECIONAR
        */
        return redirect('/profile/'.auth()->user()->id);
        
    }

    /*
            MOSTRAR POSTAGEM
    */
    //se o argumento da função tem o mesmo nome da variavel na colocada na rota show
    //é possivel fazer o preenchimento da variavel automaticamente com o objeto postagem
    //nome do recurso: route model binding
    //adicionar \App\Post antes da variavel
    //esse recurso tambem direciona para 404
    public function show(\App\Post $post)
    {
        //passar o conteudo de post para a view
        //a função compact() recebe a(s) string(s) com o(s) nome(s) da(s) variável(is) compacta em um vetor
        return view('posts.show',compact('post'));
    }
}
