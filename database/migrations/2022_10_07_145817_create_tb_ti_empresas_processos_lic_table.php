<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ti_empresas_processos_lic', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj');
            $table->string('razao');
            $table->string('endereco');
            $table->string('cpf_representante');
            $table->string('nome_representante');
            $table->string('email1');
            $table->string('email2');
            $table->string('email3');
            $table->string('tel1');
            $table->string('tel2');
            $table->string('tel3');
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
        Schema::dropIfExists('tb_ti_empresas_processos_lic');
    }
};
