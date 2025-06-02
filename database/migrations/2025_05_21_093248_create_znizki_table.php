<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('znizki', function (Blueprint $table) {
            $table->id('id_znizki');
            $table->string('nazwa_znizki');
            $table->integer('wartosc'); // np. 10 (procent)
            $table->text('opis')->nullable();
            $table->boolean('active')->default(true); // Dodana kolumna active
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('znizki');
    }
};
