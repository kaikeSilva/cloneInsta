<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//adicionar suporte para email
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
        ADICIONAR EVENTO DE CRIAÇÃO DE USUÁRIO
    */
    //Quando o usúario é criado tambem é preciso criar seu profile
    //Quando se cria uma nova model de User o metodo boot é chamado
    //dentro desse metodo é possível configurar eventos
    protected static function boot()
    {
        //chamar implementação do pai
        parent::boot();

        //Setar evento
        //existem varios outros eventos, checar documentação
        static::created(function ($user) {
            //criar profile a partir da relação com usuário
            $user->profile()->create([
                //setar valores default para alguns atributos de profile
                'title' => $user->username,
            ]);


            //enviar e-mail de boas vindas quando o usuário se registrar
            //Para o protocolo SMTP em .env laravel ja possui um ambiente de integração com mailtrap
            //basta colocar um usuário e uma senha no arquivo para completar a configuração
            //'mailabels', 'markdown' -- procurar depois
            //criar um email pelo terminal: php artisan make:mail NewUserWelcomeMail -m emai.welcome-email
            Mail::to($user->email)->send(new NewUserWelcomeMail());


        });
    }

    public function posts()
    {
        /*
            RETORNAR POSTS DO USUÁRIO
        */
        //ordenar o retorno pela data de criação, imagem criadas por ultimo aparecem primeiro
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    //relação muitos para muitos de seguindo
    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
