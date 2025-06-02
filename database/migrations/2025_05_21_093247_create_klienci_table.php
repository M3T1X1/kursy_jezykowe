<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('klienci', function (Blueprint $table) {
            $table->id('id_klienta');
            $table->string('email')->unique();
            $table->string('haslo');
            $table->string('imie');
            $table->string('nazwisko');
            $table->string('adres');
            $table->string('nr_telefonu');
            $table->string('adres_zdjecia')->nullable();
            $table->string('role')->default('klient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klienci');
    }
};
