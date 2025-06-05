<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'imie',
        'nazwisko',
        'email',
        'nr_telefonu',
        'course_id',
        'base_price'
    ];
     
        public function course()
        {
            return $this->belongsTo(Course::class, 'course_id', 'id_kursu');
        }

}
