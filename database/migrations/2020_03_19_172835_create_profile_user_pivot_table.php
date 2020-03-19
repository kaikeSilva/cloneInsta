<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    TABELA PARA RELAÇÃO MUITOS PARA MUITOS
*/
//para uma relação muitos para muitos o primeiro passo é criar uma migration que
//representa a ligação entre duas tabelas.
//como no medelo entidade relacionamento a tabela contem o id de ambas as entidades que fazem parte da
//relação.
//comando para criar a tabela para essa relação:
//php artisan make:migration create_profile_user_pivot_table --create Profile_user
//depois de criada a migração executar: php artisan migrate para levar a tabela para o banco

class CreateProfileUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Profile_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Profile_user');
    }
}
