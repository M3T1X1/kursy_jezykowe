<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('klienci_znizki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_klienta');
            $table->unsignedBigInteger('id_znizki');
            $table->timestamps();

            $table->foreign('id_klienta')->references('id_klienta')->on('klienci')->onDelete('cascade');
            $table->foreign('id_znizki')->references('id_znizki')->on('znizki')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klienci_znizki');
    }
};

