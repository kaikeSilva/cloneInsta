<?php

use Illuminate\Support\Facades\Route;

use App\Mail\NewUserWelcomeMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();


/*
    ROTA PARA VISUALIZAR O EMAIL
*/
Route::get('/email', function() {
    return new NewUserWelcomeMail();
});

/*
    ROTAS PARA AXIOS VINDAS DO FRONT EM REACT
*/


//rota https para colocar seguidores no perfil
Route::post('/follow/{user}','FollowsController@store');

/*
    ROTAS PARA PROFILES
*/



//rota https para mostrar determinada página na tela com os argumentos entre {}
//Padrao restfull para action SHOW
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');

//rota https para pagina de edição de registros
//Padrao restfull para action EDIT
Route::get('/profile/{user}/edit','ProfilesController@edit')->name('profile.edit');

//rota https para atualizar registros
//Padrao restfull para action EDIT
Route::patch('/profile/{user}','ProfilesController@update')->name('profile.update');



/*
    ROTAS PARA POSTAGEM
*/

Route::get('/', 'PostsController@index');
//rota https para mostrar um certo recurso por um identificador
//Padrao restfull para action SHOW
Route::get('/p/{post}', 'PostsController@show');

//rota https para criar um novo registro
//Padrão restfull para action CREATE
//por algum motivo essa rota parou de funcionar, algo haver com a letra 'p',vai saber
//letra p foi trocada por post
/*
    O '404 NOT FOUND' que acontecia por causa da letra 'p' era pos causa da ordem das rotas,
    com /p/{post} é checada primeiro, entrava nela pois tem o mesmo formato de /p/create,
    porem não encontrava nenhum post com id = 'create' e retornava 404.

    Para resolver esse conflito é uma boa pratica deixar rotas dinâmicas mais abaixo.
*/
Route::get('/post/create','PostsController@create');

//rota https para criar um novo registro
//Padrao restfull para action STORE
Route::post('/p', 'PostsController@store');
