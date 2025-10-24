<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_patient';
    protected $fillable = ['fio', 'category', 'birth_date'];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id_patient');
    }
}