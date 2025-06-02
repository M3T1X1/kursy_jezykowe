<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Klient extends Authenticatable
{
    protected $table = 'klienci';
    protected $primaryKey = 'id_klienta';

    protected $fillable = [
        'email', 'haslo', 'imie', 'nazwisko', 'adres', 'nr_telefonu', 'adres_zdjecia'
    ];

    // Jeśli pole hasła to "haslo", dodaj:
    public function getAuthPassword()
    {
        return $this->haslo;
    }
}

