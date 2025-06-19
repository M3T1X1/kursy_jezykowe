<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Instruktor extends Model
{
    protected $table = 'instruktorzy';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email', 'imie', 'nazwisko', 'jezyk', 'adres_zdjecia', 'poziom', 'placa',
        'is_deleted'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeDeleted($query)
    {
        return $query->where('is_deleted', true);
    }

    public function kursy()
    {
        return $this->hasMany(Course::class, 'id_instruktora', 'id');
    }
}
