<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function znizki()
    {
        return $this->belongsToMany(Znizka::class, 'klient_znizka', 'id_klienta', 'id_znizki')->withTimestamps();
    }

    public function updateAutomaticDiscounts()
    {
        $now = Carbon::now();

        $wiosenna = Znizka::where('nazwa_znizki', 'Wiosenna')->first();
        $blackFriday = Znizka::where('nazwa_znizki', 'Black Friday')->first();
        $nowyKlient = Znizka::where('nazwa_znizki', 'Nowy klient')->first();

        $autoDiscountIds = collect([$wiosenna, $blackFriday, $nowyKlient])->filter()->pluck('id_znizki')->toArray();

        // Usuń stare automatyczne zniżki, aby nie dublować
        $this->znizki()->detach($autoDiscountIds);

        if ($this->created_at && $this->created_at->greaterThan($now->copy()->subDays(30)) && $nowyKlient) {
            $this->znizki()->attach($nowyKlient->id_znizki);
        }

        if (in_array($now->month, [3, 4, 5]) && $wiosenna) {
            $this->znizki()->attach($wiosenna->id_znizki);
        }

        if ($now->isSameDay(Carbon::create($now->year, 11, 26)) && $blackFriday) {
            $this->znizki()->attach($blackFriday->id_znizki);
        }
    }
}

