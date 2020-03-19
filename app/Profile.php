<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    //retornar imagem cadastrada ou imagem default
    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'uploads\Ec4AiSeHe7gPRBhi1FBwS1O233xC1upRAtaDqCU9.png';
        return '/storage/'.$imagePath;
    }

    //desligar proteção de MassAssignment
    /*
        Quando o request inteiro é passado pode haver dados submetidos que não fazem parte dos
        dados da aplicação.
        Aqui foi retirada essa proteção pois os campos de input estão sendo validados na controller
    */ 
    protected $guarded = [];

    //funçãop para criar a relação de 1 para 1 de usuário e profile
    //atraves dessa função é possivel retornar o usuario que esta relacionado a profile
    public function user() {
        return $this->belongsTo(User::class);
    }

    //relação muitos para muitos de seguidores
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
