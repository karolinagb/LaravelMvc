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
        Schema::create('temporadas', function (Blueprint $table) {
            $table->id();
            //unsignedTinyInteger = inteiro pequeno e positivo
            $table->unsignedTinyInteger('numero');

            //unsignedBigInteger = inteiro maior e positivo
            // $table->unsignedBigInteger('serie_id') //1;

            //chave estrangeira, que referencia a coluna id da tabela series
            // $table->foreign('series_id')->references('id')->on('series'); //2

            //a linha 1 e 2 comentada acima também pode ser substituída por:
            $table->foreignId('serie_id')->constrained();
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
        Schema::dropIfExists('temporadas');
    }
};
