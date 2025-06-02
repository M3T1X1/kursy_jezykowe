<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
        protected $fillable = ['name', 'email', 'phone', 'course_id'];
    
        public function course()
        {
            return $this->belongsTo(Course::class, 'course_id', 'id_kursu');
        }

}
