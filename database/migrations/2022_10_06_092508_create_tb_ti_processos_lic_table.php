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
        Schema::create('tb_ti_processos_lic', function (Blueprint $table) {
            $table->id();
            $table->string('p_licitatorio');
            $table->string('p_eletronico')->nullable();
            $table->string('r_preco')->nullable();
            $table->string('objetivo');
            $table->text('descritivo');
            $table->string('fiscal_mat')->nullable();
            $table->string('fiscal_name')->nullable();
            $table->string('gestor_mat')->nullable();
            $table->string('gestor_name')->nullable();            
            $table->foreignID('tipos_id')->references('id')->on('tb_ti_tipos_processos_lic');
            $table->foreignID('status_id')->references('id')->on('tb_ti_status_processos_lic');
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
        Schema::dropIfExists('tb_ti_processos_lic');
    }
};
