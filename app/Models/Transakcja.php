<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transakcja extends Model
{
    protected $table = 'transakcje';
    protected $primaryKey = 'id_transakcji';

    protected $fillable = ['id_kursu', 'id_klienta', 'cena_ostateczna', 'status', 'data'];

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
}
