<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalSeeder extends Seeder
{
    public function run()
    {
        // Отключаем проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Очищаем таблицы в правильном порядке
        Appointment::query()->delete();
        Patient::query()->delete();
        Doctor::query()->delete();
        
        // Сбрасываем автоинкремент
        DB::statement('ALTER TABLE appointments AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE patients AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE doctors AUTO_INCREMENT = 1');
        
        // Включаем проверку внешних ключей обратно
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Создаем пациентов
        $patients = [
            [
                'fio' => 'Иванов Сергей Петрович',
                'category' => 'пенсионер',
                'birth_date' => '1955-03-15'
            ],
            [
                'fio' => 'Петрова Мария Ивановна',
                'category' => 'работающий',
                'birth_date' => '1980-07-22'
            ],
            [
                'fio' => 'Сидоров Алексей Владимирович',
                'category' => 'пенсионер',
                'birth_date' => '1958-11-30'
            ],
            [
                'fio' => 'Козлова Елена Сергеевна',
                'category' => 'студент',
                'birth_date' => '1995-02-14'
            ],
            [
                'fio' => 'Николаев Дмитрий Олегович',
                'category' => 'работающий',
                'birth_date' => '1978-09-08'
            ],
            [
                'fio' => 'Иванов С.П.',
                'category' => 'пенсионер',
                'birth_date' => '1957-12-10'
            ],
            [
                'fio' => 'Федорова Ольга Михайловна',
                'category' => 'пенсионер',
                'birth_date' => '1959-06-25'
            ]
        ];

        foreach ($patients as $patientData) {
            Patient::create($patientData);
        }

        // Создаем врачей
        $doctors = [
            [
                'fio' => 'Иванов Иван Иванович',
                'specialty' => 'терапевт',
                'experience' => 15,
                'birth_date' => '1970-01-01'
            ],
            [
                'fio' => 'Петров Петр Петрович',
                'specialty' => 'терапевт',
                'experience' => 20,
                'birth_date' => '1965-03-10'
            ],
            [
                'fio' => 'Сидорова Анна Владимировна',
                'specialty' => 'окулист',
                'experience' => 12,
                'birth_date' => '1975-08-15'
            ],
            [
                'fio' => 'Козлов Михаил Сергеевич',
                'specialty' => 'хирург',
                'experience' => 25,
                'birth_date' => '1960-11-20'
            ],
            [
                'fio' => 'Никитина Татьяна Олеговна',
                'specialty' => 'окулист',
                'experience' => 8,
                'birth_date' => '1982-04-05'
            ],
            [
                'fio' => 'Морозов Андрей Викторович',
                'specialty' => 'терапевт',
                'experience' => 0,
                'birth_date' => '1990-07-12'
            ],
            [
                'fio' => 'Волков Сергей Иванович',
                'specialty' => 'терапевт',
                'experience' => 30,
                'birth_date' => '1960-01-15'
            ]
        ];

        foreach ($doctors as $doctorData) {
            Doctor::create($doctorData);
        }

        // Создаем приемы
        $appointments = [
            // Текущий год - для запроса 1
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(10)->setTime(9, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(15)->setTime(10, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 1,
                'doctor_id' => 2,
                'datetime' => Carbon::now()->startOfYear()->addDays(20)->setTime(11, 0),
                'office' => '102'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 3,
                'datetime' => Carbon::now()->startOfYear()->addDays(25)->setTime(14, 0),
                'office' => '201'
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(30)->setTime(15, 0),
                'office' => '101'
            ],

            // Январь прошлого года - для запроса 2
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->subYear()->startOfYear()->addDays(5)->setTime(9, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->subYear()->startOfYear()->addDays(7)->setTime(10, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->subYear()->startOfYear()->addDays(10)->setTime(11, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->subYear()->startOfYear()->addDays(12)->setTime(14, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 5,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->subYear()->startOfYear()->addDays(15)->setTime(15, 0),
                'office' => '101'
            ],

            // Для запроса 4 - врачи той же специальности
            [
                'patient_id' => 1,
                'doctor_id' => 2,
                'datetime' => Carbon::now()->startOfYear()->addDays(5)->setTime(9, 0),
                'office' => '102'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 2,
                'datetime' => Carbon::now()->startOfYear()->addDays(6)->setTime(10, 0),
                'office' => '102'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 2,
                'datetime' => Carbon::now()->startOfYear()->addDays(7)->setTime(11, 0),
                'office' => '102'
            ],

            // Для запроса 6 - пациент-пенсионер с многократными посещениями окулиста
            [
                'patient_id' => 6,
                'doctor_id' => 3,
                'datetime' => Carbon::now()->startOfYear()->addDays(5)->setTime(9, 0),
                'office' => '201'
            ],
            [
                'patient_id' => 6,
                'doctor_id' => 3,
                'datetime' => Carbon::now()->startOfYear()->addDays(25)->setTime(10, 0),
                'office' => '201'
            ],
            [
                'patient_id' => 6,
                'doctor_id' => 3,
                'datetime' => Carbon::now()->startOfYear()->addDays(45)->setTime(11, 0),
                'office' => '201'
            ],

            // Для запроса 7 - пациенты предпенсионного возраста
            [
                'patient_id' => 7,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(8)->setTime(9, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 7,
                'doctor_id' => 2,
                'datetime' => Carbon::now()->startOfYear()->addDays(18)->setTime(10, 0),
                'office' => '102'
            ],
            [
                'patient_id' => 7,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(28)->setTime(11, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 7,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfYear()->addDays(38)->setTime(14, 0),
                'office' => '101'
            ],

            // Для запроса 10 - приемы на текущей неделе у Иванова И.И.
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfWeek()->addDays(1)->setTime(9, 0),
                'office' => '101'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfWeek()->addDays(1)->setTime(10, 30),
                'office' => '101'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'datetime' => Carbon::now()->startOfWeek()->addDays(3)->setTime(14, 0),
                'office' => '101'
            ]
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        $this->command->info('Тестовые данные созданы успешно!');
        $this->command->info('Создано пациентов: ' . Patient::count());
        $this->command->info('Создано врачей: ' . Doctor::count());
        $this->command->info('Создано приемов: ' . Appointment::count());
    }
}