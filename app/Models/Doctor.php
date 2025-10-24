<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_doctor';
    protected $fillable = ['fio', 'specialty', 'experience', 'birth_date'];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id_doctor');
    }

    public function mentors()
    {
        return $this->hasMany(Doctor::class, 'specialty', 'specialty')
            ->where('experience', '>=', DB::raw('doctors.experience + 10'));
    }
}