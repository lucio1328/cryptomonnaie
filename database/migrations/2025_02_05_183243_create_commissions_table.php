<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('commission', function (Blueprint $table) {
            $table->id('Id_commission'); 
            $table->unsignedBigInteger('Id_cryptos');
            $table->unsignedBigInteger('Id_type_fonds');
            $table->decimal('pourcentage', 10, 5);
            $table->date('daty');

            $table->foreign('id_cryptos')->references('id_cryptos')->on('cryptos')->onDelete('cascade');
            $table->foreign('id_type_fonds')->references('id_type_fonds')->on('type_fonds')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('commission');
    }
};
