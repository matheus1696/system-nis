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
        Schema::create('tb_cnep_palestrantes', function (Blueprint $table) {
            $table->id();
            $table->string('palestrante');
            $table->string('cpf');
            $table->foreignId('capacitacao_id')->references('id')->on('tb_cnep_capacitacoes');
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
        Schema::dropIfExists('tb_palestrantes');
    }
};
