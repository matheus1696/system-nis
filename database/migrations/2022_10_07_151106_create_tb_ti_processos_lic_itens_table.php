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
        Schema::create('tb_ti_processos_lic_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignID('pl_id')->references('id')->on('tb_ti_processos_lic');
            $table->foreignID('empresa_id')->references('id')->on('tb_ti_empresas_processos_lic')->default(1);
            $table->string('n_item');
            $table->string('produto');            
            $table->string('descricao')->nullable();          
            $table->string('tipos_und');
            $table->string('quant');
            $table->string('p_unico')->nullable();
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
        Schema::dropIfExists('tb_ti_status_processos_lic_itens');
    }
};
