<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'kursy';
    protected $primaryKey = 'id_kursu';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $casts = [
        'data_rozpoczecia' => 'date',
        'data_zakonczenia' => 'date',
    ];

    protected $fillable = [
        'jezyk',
        'poziom',
        'data_rozpoczecia',
        'data_zakonczenia',
        'cena',
        'liczba_miejsc',
        'id_instruktora',
        'zdjecie',
        'instruktor_imie',
        'instruktor_nazwisko',
        'instruktor_email',
        'instruktor_jezyk',
        'instruktor_poziom',
        'instruktor_placa',
        'instruktor_adres_zdjecia',
    ];

    // Relacje
    public function instructor() {
        return $this->belongsTo(Instruktor::class, 'id_instruktora', 'id');
    }

    public function transakcje() {
        return $this->hasMany(Transakcja::class, 'id_kursu', 'id_kursu');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'course_id', 'id_kursu');
    }

    // Accessory dla denormalizowanych danych
    public function getInstructorFullNameAttribute()
    {
        if ($this->instruktor_imie && $this->instruktor_nazwisko) {
            return $this->instruktor_imie . ' ' . $this->instruktor_nazwisko;
        }

        // Fallback na relację jeśli denormalizowane dane nie istnieją
        if ($this->instructor) {
            return $this->instructor->imie . ' ' . $this->instructor->nazwisko;
        }

        return 'Brak instruktora';
    }

    public function getInstructorPhotoUrlAttribute()
    {
        if ($this->instruktor_adres_zdjecia) {
            $sciezkaZdjecia = public_path($this->instruktor_adres_zdjecia);
            if (file_exists($sciezkaZdjecia)) {
                return asset($this->instruktor_adres_zdjecia);
            }
        }

        // Fallback na relację
        if ($this->instructor && $this->instructor->adres_zdjecia) {
            $sciezkaZdjecia = public_path($this->instructor->adres_zdjecia);
            if (file_exists($sciezkaZdjecia)) {
                return asset($this->instructor->adres_zdjecia);
            }
        }

        return asset('img/ZdjeciaInstruktorow/brak.png');
    }

    // Sprawdza czy ma przypisanego instruktora (aktywnego lub w danych denormalizowanych)
    public function hasInstructor()
    {
        return ($this->id_instruktora && $this->instructor) ||
               ($this->instruktor_imie && $this->instruktor_nazwisko);
    }
}
