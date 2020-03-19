<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //desligar proteção de MassAssignment
    /*
        Quando o request inteiro é passado pode haver dados submetidos que não fazem parte dos
        dados da aplicação.
        Aqui foi retirada essa proteção pois os campos de input estão sendo validados na controller
    */ 
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
