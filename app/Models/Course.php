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
    ];

    public function instructor() {
        return $this->belongsTo(Instruktor::class, 'id_instruktora', 'id');
    }

    public function transakcje() {
        return $this->hasMany(Transakcja::class, 'id_kursu', 'id_kursu');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'course_id', 'id_kursu');
    }
}
