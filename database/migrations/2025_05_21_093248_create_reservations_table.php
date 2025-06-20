<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->string('imie');
        $table->string('nazwisko');
        $table->string('email');
        $table->string('nr_telefonu');
        $table->unsignedBigInteger('course_id');
        $table->decimal('base_price', 10, 2)->after('course_id');
        $table->foreign('course_id')->references('id_kursu')->on('kursy')->onDelete('cascade');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
