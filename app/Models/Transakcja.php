<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transakcja extends Model
{
    protected $table = 'transakcje';
    protected $primaryKey = 'id_transakcji';

    
    protected $fillable = ['id_kursu', 'id_klienta', 'cena_ostateczna', 'status', 'data', 'reservation_id', 'klient_imie', 'klient_nazwisko', 'klient_email'];

    protected $casts = [
        'data' => 'date',
    ];

    public function klient()
    {
        return $this->belongsTo(Klient::class, 'id_klienta', 'id_klienta');
    }

    public function kurs()
    {
        return $this->belongsTo(Course::class, 'id_kursu', 'id_kursu');
    }

   
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
}
