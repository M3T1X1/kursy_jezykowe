<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Znizka extends Model
{
    protected $table = 'znizki';
    protected $primaryKey = 'id_znizki';
    public $timestamps = true;

    protected $fillable = [
        'nazwa_znizki',
        'wartosc',
        'opis',
    ];
}
