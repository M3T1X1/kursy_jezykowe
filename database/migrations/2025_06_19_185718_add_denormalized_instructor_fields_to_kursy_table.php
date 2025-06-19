<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('kursy', function (Blueprint $table) {
            // 1. Usuń foreign key constraint
            $table->dropForeign(['id_instruktora']);

            // 2. Zmień id_instruktora na nullable
            $table->unsignedBigInteger('id_instruktora')->nullable()->change();

            // 3. Dodaj denormalizowane kolumny
            $table->string('instruktor_imie')->nullable();
            $table->string('instruktor_nazwisko')->nullable();
            $table->string('instruktor_email')->nullable();
            $table->string('instruktor_jezyk')->nullable();
            $table->string('instruktor_poziom')->nullable();
            $table->decimal('instruktor_placa', 10, 2)->nullable();
            $table->string('instruktor_adres_zdjecia')->nullable();
        });

        // 4. Migruj istniejące dane
        $kursy = DB::table('kursy')->get();
        foreach ($kursy as $kurs) {
            if ($kurs->id_instruktora) {
                $instruktor = DB::table('instruktorzy')->find($kurs->id_instruktora);
                if ($instruktor) {
                    DB::table('kursy')->where('id_kursu', $kurs->id_kursu)->update([
                        'instruktor_imie' => $instruktor->imie,
                        'instruktor_nazwisko' => $instruktor->nazwisko,
                        'instruktor_email' => $instruktor->email,
                        'instruktor_jezyk' => $instruktor->jezyk,
                        'instruktor_poziom' => $instruktor->poziom,
                        'instruktor_placa' => $instruktor->placa,
                        'instruktor_adres_zdjecia' => $instruktor->adres_zdjecia,
                    ]);
                }
            }
        }
    }

    public function down(): void {
        Schema::table('kursy', function (Blueprint $table) {
            // Przywróć foreign key
            $table->foreign('id_instruktora')->references('id')->on('instruktorzy')->onDelete('cascade');

            // Usuń denormalizowane kolumny
            $table->dropColumn([
                'instruktor_imie',
                'instruktor_nazwisko',
                'instruktor_email',
                'instruktor_jezyk',
                'instruktor_poziom',
                'instruktor_placa',
                'instruktor_adres_zdjecia'
            ]);
        });
    }
};
