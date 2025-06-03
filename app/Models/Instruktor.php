<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruktor extends Model
{
    protected $table = 'instruktorzy';  // tutaj dokładnie ta nazwa

    protected $primaryKey = 'id';

    protected $fillable = ['email', 'imie', 'nazwisko', 'jezyk', 'adres_zdjecia', 'poziom', 'placa'];

    public function kursy()
    {
        return $this->hasMany(Course::class, 'id_instruktora', 'id');
    }
}
