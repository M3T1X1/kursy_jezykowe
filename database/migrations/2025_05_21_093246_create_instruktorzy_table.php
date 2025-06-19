<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('instruktorzy', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('imie');
            $table->string('nazwisko');
            $table->string('jezyk');
            $table->string('adres_zdjecia')->nullable();
            $table->string('poziom');
            $table->decimal('placa', 10, 2);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('instruktorzy');
    }
};

