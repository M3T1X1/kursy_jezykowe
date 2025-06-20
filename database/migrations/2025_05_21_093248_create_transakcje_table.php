<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transakcje', function (Blueprint $table) {
            $table->id('id_transakcji');
            $table->unsignedBigInteger('id_kursu')->nullable();;
            $table->unsignedBigInteger('id_klienta')->nullable();
            $table->string('kurs_jezyk');
            $table->string('kurs_poziom');
            $table->date('kurs_data_rozpoczecia');
            $table->string('klient_imie');
            $table->string('klient_nazwisko');
            $table->string('klient_email');
            $table->decimal('cena_ostateczna', 10, 2);
            $table->string('status');
            $table->date('data');
            $table->timestamps();
            $table->unsignedBigInteger('reservation_id')->nullable();

            $table->foreign('id_kursu')
                ->references('id_kursu')
                ->on('kursy')
                ->onDelete('set null');

            $table->foreign('id_klienta')
                  ->references('id_klienta')
                  ->on('klienci')
                  ->onDelete('set null');
                  
            $table->foreign('reservation_id')
                    ->references('id')
                    ->on('reservations')
                    ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transakcje');
    }
};
