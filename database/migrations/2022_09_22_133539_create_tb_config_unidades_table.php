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
        Schema::create('tb_config_unidades', function (Blueprint $table) {
            $table->id();
            $table->integer('cnes');
            $table->string('name');           
            $table->string('end_logradouro');            
            $table->string('end_num');
            $table->string('end_complemento')->nullable();
            $table->string('end_bairro');
            $table->integer('end_lat')->nullable();
            $table->integer('end_log')->nullable();
            $table->foreignID('status_id')->references('id')->on('tb_config_status_unidades');
            $table->foreignID('bloco_id')->references('id')->on('tb_config_blocos');
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
        Schema::dropIfExists('tb_config_unidades');
    }
};
