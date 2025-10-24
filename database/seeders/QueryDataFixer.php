<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QueryDataFixer extends Seeder
{
    public function run()
    {
        $currentYear = now()->year;
        
        // ДАННЫЕ ДЛЯ ЗАПРОСА 4
        // Убедимся что у других терапевтов больше пациентов чем у Иванова
        $ivanovId = Doctor::where('fio', 'Иванов Иван Иванович')->value('id_doctor');
        $petrovId = Doctor::where('fio', 'Петров Петр Петрович')->value('id_doctor');
        
        // Добавим приемы Петрову в текущем году
        for ($i = 1; $i <= 6; $i++) {
            Appointment::create([
                'patient_id' => $i,
                'doctor_id' => $petrovId,
                'datetime' => Carbon::create($currentYear, rand(1, 6), rand(1, 28), rand(9, 16), 0),
                'office' => '102'
            ]);
        }

        // ДАННЫЕ ДЛЯ ЗАПРОСА 7
        // Создаем пациентов предпенсионного возраста
        $preRetirementPatient = Patient::create([
            'fio' => 'Семенов Виктор Николаевич',
            'category' => 'работающий',
            'birth_date' => '1959-05-15' // 55-60 лет
        ]);

        // Добавляем приемы: посетил 2 разных врача
        Appointment::create([
            'patient_id' => $preRetirementPatient->id_patient,
            'doctor_id' => $ivanovId,
            'datetime' => Carbon::create($currentYear, 1, 10, 9, 0),
            'office' => '101'
        ]);
        
        Appointment::create([
            'patient_id' => $preRetirementPatient->id_patient,
            'doctor_id' => $petrovId,
            'datetime' => Carbon::create($currentYear, 2, 15, 10, 0),
            'office' => '102'
        ]);

        // ДАННЫЕ ДЛЯ ЗАПРОСА 10
        // Добавляем приемы Иванову на текущей неделе
        $startOfWeek = now()->startOfWeek();
        
        Appointment::create([
            'patient_id' => 1,
            'doctor_id' => $ivanovId,
            'datetime' => $startOfWeek->copy()->addDays(1)->setTime(9, 0), // Понедельник
            'office' => '101'
        ]);
        
        Appointment::create([
            'patient_id' => 2,
            'doctor_id' => $ivanovId,
            'datetime' => $startOfWeek->copy()->addDays(1)->setTime(11, 0), // Понедельник
            'office' => '101'
        ]);
        
        Appointment::create([
            'patient_id' => 3,
            'doctor_id' => $ivanovId,
            'datetime' => $startOfWeek->copy()->addDays(3)->setTime(14, 0), // Среда
            'office' => '101'
        ]);

        $this->command->info('Дополнительные данные для запросов 4,7,10 созданы!');
    }
}