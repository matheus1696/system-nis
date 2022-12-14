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
        Schema::create('tb_dashboard', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');            
            $table->text('link');   
            $table->foreignID('icons_id')->references('id')->on('tb_config_icons');             
            $table->foreignID('bloco_id')->references('id')->on('tb_config_blocos');                 
            $table->text('descricao');
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
        Schema::dropIfExists('tb_dashboard');
    }
};
