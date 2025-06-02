<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruktor extends Model
{
    protected $table = 'instruktorzy';
    protected $primaryKey = 'id'; // standard

    protected $fillable = ['email', 'imie', 'nazwisko', 'jezyk', 'adres_zdjecia', 'poziom', 'placa'];

    public function kursy()
    {
        return $this->hasMany(Kurs::class, 'id_instruktora', 'id');
    }
}
