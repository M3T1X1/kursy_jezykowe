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
    Schema::table('klienci', function ($table) {
        $table->string('role')->default('klient');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('klienci', function ($table) {
        $table->dropColumn('role');
    });
}
};
