<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kursy', function (Blueprint $table) {
            $table->id('id_kursu');
            $table->decimal('cena', 10, 2);
            $table->string('jezyk');
            $table->string('poziom');
            $table->date('data_rozpoczecia');
            $table->date('data_zakonczenia');
            $table->integer('liczba_miejsc');
            $table->unsignedBigInteger('id_instruktora');
            $table->foreign('id_instruktora')->references('id')->on('instruktorzy')->onDelete('cascade');
            $table->string('zdjecie')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kursy');
    }
};
