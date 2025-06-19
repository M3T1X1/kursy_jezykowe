<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transakcje', function (Blueprint $table) {
            $table->id('id_transakcji');
            $table->unsignedBigInteger('id_kursu');
            $table->unsignedBigInteger('id_klienta')->nullable();
            $table->string('klient_imie');
            $table->string('klient_nazwisko');
            $table->string('klient_email');
            $table->decimal('cena_ostateczna', 10, 2);
            $table->string('status');
            $table->date('data');
            $table->timestamps();

            $table->foreign('id_kursu')
                  ->references('id_kursu')
                  ->on('kursy')
                  ->onDelete('cascade');

            $table->foreign('id_klienta')
                  ->references('id_klienta')
                  ->on('klienci')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transakcje');
    }
};
