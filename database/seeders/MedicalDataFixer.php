<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalDataFixer extends Seeder
{
    public function run()
    {
        // Очищаем таблицы
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Appointment::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $currentYear = now()->year;
        $lastYear = now()->subYear()->year;

        // Создаем приемы с правильными датами
        $appointments = [
            // ЗАПРОС 1 - Текущий год
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'datetime' => Carbon::create($currentYear, 1, 15, 9, 0), // Январь текущего года
                'office' => '101'
            ],
            [
                'patient_id' => 2, 
                'doctor_id' => 1,
                'datetime' => Carbon::create($currentYear, 2, 10, 10, 0), // Февраль текущего года
                'office' => '101'
            ],
            [
                'patient_id' => 1,
                'doctor_id' => 2,
                'datetime' => Carbon::create($currentYear, 3, 5, 11, 0), // Март текущего года
                'office' => '102'
            ],

            // ЗАПРОС 2 - Январь прошлого года, терапевты
            [
                'patient_id' => 1,
                'doctor_id' => 1, // Иванов Иван Иванович - терапевт
                'datetime' => Carbon::create($lastYear, 1, 5, 9, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'datetime' => Carbon::create($lastYear, 1, 7, 10, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1, 
                'datetime' => Carbon::create($lastYear, 1, 10, 11, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 1,
                'datetime' => Carbon::create($lastYear, 1, 12, 14, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 5,
                'doctor_id' => 1,
                'datetime' => Carbon::create($lastYear, 1, 15, 15, 0),
                'office' => '101'
            ],

            // ЗАПРОС 8 - Разные месяцы прошлого года
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'datetime' => Carbon::create($lastYear, 1, 10, 9, 0), // Январь
                'office' => '101'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1, 
                'datetime' => Carbon::create($lastYear, 1, 10, 10, 0), // Январь (тот же день)
                'office' => '101'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 2,
                'datetime' => Carbon::create($lastYear, 2, 15, 11, 0), // Февраль
                'office' => '102'
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 3,
                'datetime' => Carbon::create($lastYear, 2, 15, 14, 0), // Февраль (тот же день)
                'office' => '201'
            ],
            [
                'patient_id' => 5,
                'doctor_id' => 1,
                'datetime' => Carbon::create($lastYear, 3, 20, 9, 0), // Март
                'office' => '101'
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        $this->command->info('Исправленные данные созданы!');
        $this->command->info('Приемов создано: ' . Appointment::count());
    }
}