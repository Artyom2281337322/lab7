<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalQueryController extends Controller
{
    /**
     * 1) Извлечь пациентов и врачей текущего года
     */
    public function query1()
    {
        $currentYear = now()->year;

        // Получаем данные отдельно и объединяем вручную
        $patients = Patient::select(
                'patients.id_patient as id',
                'patients.fio',
                DB::raw('COUNT(appointments.id) as appointment_count'),
                DB::raw("'Пациент' as type")
            )
            ->join('appointments', 'patients.id_patient', '=', 'appointments.patient_id')
            ->whereYear('appointments.datetime', $currentYear)
            ->groupBy('patients.id_patient', 'patients.fio')
            ->get();

        $doctors = Doctor::select(
                'doctors.id_doctor as id',
                'doctors.fio',
                DB::raw('COUNT(appointments.id) as appointment_count'), 
                DB::raw("'Врач' as type")
            )
            ->join('appointments', 'doctors.id_doctor', '=', 'appointments.doctor_id')
            ->whereYear('appointments.datetime', $currentYear)
            ->groupBy('doctors.id_doctor', 'doctors.fio')
            ->get();

        // Объединяем и сортируем вручную
        $result = $patients->concat($doctors)
            ->sortBy([
                ['type', 'asc'],
                ['fio', 'asc']
            ])
            ->values();

        return response()->json($result);
    }

    /**
     * 2) Врачи-терапевты с загруженностью > 0.75 в январе прошлого года
     */
    public function query2()
    {
        $lastYearJanuary = now()->subYear()->startOfYear();

        $result = Doctor::select(
                'doctors.id_doctor as id',
                'doctors.fio',
                DB::raw('COUNT(appointments.id) as patient_count')
            )
            ->join('appointments', 'doctors.id_doctor', '=', 'appointments.doctor_id')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id_patient')
            ->where('doctors.specialty', 'терапевт')
            ->whereBetween('appointments.datetime', [
                $lastYearJanuary->copy()->startOfMonth(),
                $lastYearJanuary->copy()->endOfMonth()
            ])
            ->where('patients.category', '<>', 'сторонний')
            ->groupBy('doctors.id_doctor', 'doctors.fio')
            ->having(DB::raw('COUNT(appointments.id) / 5'), '>', 0.75)
            ->orderBy('doctors.fio')
            ->get();

        return response()->json($result);
    }

    /**
     * 3) Статистика посещений по категориям пациентов
     */
    public function query3()
    {
        $result = Patient::select(
                'patients.category',
                DB::raw('COUNT(appointments.id) as appointment_count'),
                DB::raw('COUNT(DISTINCT appointments.doctor_id) as doctors_count')
            )
            ->join('appointments', 'patients.id_patient', '=', 'appointments.patient_id')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id_doctor')
            ->where('patients.birth_date', '>=', '1976-01-01')
            ->where('doctors.experience', '>=', 1)
            ->groupBy('patients.category')
            ->orderBy('patients.category')
            ->get();

        return response()->json($result);
    }

    /**
     * 4) Врачи той же специальности, что и Иванов И.И., с большим количеством пациентов
     */
    public function query4()
    {
        $currentYear = now()->year;

        $ivanovSpecialty = Doctor::where('fio', 'Иванов Иван Иванович')->value('specialty');
        
        if (!$ivanovSpecialty) {
            return response()->json(['message' => 'Врач Иванов Иван Иванович не найден'], 404);
        }

        $ivanovPatientCount = Appointment::whereHas('doctor', function($query) {
                $query->where('fio', 'Иванов Иван Иванович');
            })
            ->whereYear('datetime', $currentYear)
            ->count();

        $result = Doctor::select(
                'doctors.id_doctor as id',
                'doctors.fio',
                DB::raw('COUNT(appointments.id) as patient_count')
            )
            ->join('appointments', 'doctors.id_doctor', '=', 'appointments.doctor_id')
            ->where('doctors.specialty', $ivanovSpecialty)
            ->where('doctors.fio', '<>', 'Иванов Иван Иванович')
            ->whereYear('appointments.datetime', $currentYear)
            ->groupBy('doctors.id_doctor', 'doctors.fio')
            ->having('patient_count', '>', $ivanovPatientCount)
            ->get();

        return response()->json($result);
    }

    /**
     * 5) Пациенты, не посетившие врачей пациента "Иванов С.П."
     */
    public function query5()
    {
        $currentYear = now()->year;
        $ivanovPatientId = Patient::where('fio', 'Иванов С.П.')->value('id_patient');

        if (!$ivanovPatientId) {
            return response()->json(['message' => 'Пациент Иванов С.П. не найден'], 404);
        }

        $doctorsVisitedByIvanov = Appointment::where('patient_id', $ivanovPatientId)
            ->whereYear('datetime', $currentYear)
            ->pluck('doctor_id');

        $result = Patient::select('patients.id_patient as id', 'patients.fio')
            ->whereNotIn('patients.id_patient', function($query) use ($currentYear, $doctorsVisitedByIvanov) {
                $query->select('patient_id')
                    ->from('appointments')
                    ->whereIn('doctor_id', $doctorsVisitedByIvanov)
                    ->whereYear('datetime', $currentYear);
            })
            ->orderByDesc('patients.id_patient')
            ->get();

        return response()->json($result);
    }

    /**
     * 6) Пациенты-пенсионеры: не посещали терапевта или посещали окулиста неоднократно
     */
    public function query6()
    {
        $currentYear = now()->year;

        $result = Patient::select('patients.id_patient as id', 'patients.fio')
            ->where('patients.category', 'пенсионер')
            ->where(function($query) use ($currentYear) {
                // Не посещали терапевта
                $query->whereNotIn('patients.id_patient', function($subquery) use ($currentYear) {
                    $subquery->select('appointments.patient_id')
                        ->from('appointments')
                        ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id_doctor')
                        ->where('doctors.specialty', 'терапевт')
                        ->whereYear('appointments.datetime', $currentYear);
                })
                ->orWhereIn('patients.id_patient', function($subquery) use ($currentYear) {
                    // Посещали окулиста неоднократно
                    $subquery->select('appointments.patient_id')
                        ->from('appointments')
                        ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id_doctor')
                        ->where('doctors.specialty', 'окулист')
                        ->whereYear('appointments.datetime', $currentYear)
                        ->groupBy('appointments.patient_id')
                        ->having(DB::raw('COUNT(appointments.id)'), '>', 1);
                });
            })
            ->orderBy('patients.fio')
            ->get();

        return response()->json($result);
    }

    /**
     * 7) Пациенты предпенсионного возраста с определенными условиями посещений
     */
    public function query7()
    {
        $currentYear = now()->year;
        $ageRange = [now()->subYears(60), now()->subYears(55)];

        $result = Patient::select(
                'patients.fio',
                DB::raw('COUNT(DISTINCT appointments.doctor_id) as visit_count'),
                DB::raw("CASE 
                    WHEN COUNT(DISTINCT appointments.doctor_id) = 2 THEN 'посетил 2 врачей'
                    ELSE 'посетил 3 раза или более врача \"Иванов И. И.\"'
                END as category")
            )
            ->join('appointments', 'patients.id_patient', '=', 'appointments.patient_id')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id_doctor')
            ->whereBetween('patients.birth_date', [$ageRange[0], $ageRange[1]])
            ->whereYear('appointments.datetime', $currentYear)
            ->groupBy('patients.id_patient', 'patients.fio')
            ->having(function($query) {
                $query->having(DB::raw('COUNT(DISTINCT appointments.doctor_id)'), '=', 2)
                    ->orHaving(DB::raw('SUM(CASE WHEN doctors.fio = "Иванов Иван Иванович" THEN 1 ELSE 0 END)'), '>=', 3);
            })
            ->orderBy('category')
            ->orderByDesc('visit_count')
            ->get();

        return response()->json($result);
    }

    /**
     * 8) Самый загруженный день по месяцам прошлого года
     */
public function query8()
{
    $lastYear = now()->subYear()->year;

    // Получаем все приемы за прошлый год с нужными полями
    $appointments = DB::table('appointments')
        ->select(
            'datetime',
            DB::raw("MONTHNAME(datetime) as month_name"),
            DB::raw("DATE_FORMAT(datetime, '%W, %e %M') as date"),
            DB::raw("MONTH(datetime) as month_num")
        )
        ->whereYear('datetime', $lastYear)
        ->get();

    // Группируем по месяцам и дням, считаем количество посещений
    $groupedByMonth = $appointments->groupBy('month_name')->map(function ($monthAppointments, $monthName) {
        // Группируем по дате (без времени)
        $dailyCounts = $monthAppointments->groupBy(function ($item) {
            return date('Y-m-d', strtotime($item->datetime));
        })->map(function ($dayAppointments, $date) use ($monthAppointments) {
            // Находим полную дату для этого дня
            $firstAppointment = $dayAppointments->first();
            return [
                'date' => $firstAppointment->date,
                'visit_count' => $dayAppointments->count(),
                'month_num' => $firstAppointment->month_num
            ];
        });
        
        // Находим день с максимальным количеством посещений
        $busiestDay = $dailyCounts->sortByDesc('visit_count')->first();
        
        return [
            'month_name' => $monthName,
            'date' => $busiestDay['date'],
            'visit_count' => $busiestDay['visit_count'],
            'month_num' => $busiestDay['month_num']
        ];
    });

    // Сортируем по номеру месяца
    $monthlyBusiestDays = $groupedByMonth->sortBy('month_num')->values();

    return response()->json($monthlyBusiestDays);
}

    /**
     * 9) Врачи без стажа и их возможные менторы
     */
    public function query9()
    {
        $doctors = Doctor::whereIn('experience', [0, 1])
            ->with(['mentors' => function($query) {
                $query->select('id_doctor', 'fio', 'specialty', 'experience')
                    ->orderBy('experience', 'desc');
            }])
            ->get()
            ->map(function($doctor) {
                $mentorsList = $doctor->mentors->map(function($mentor) {
                    return $mentor->fio . ' – ' . $mentor->experience . ' лет';
                })->implode(', ');
                
                return [
                    'fio' => $doctor->fio,
                    'specialty' => $doctor->specialty,
                    'experience' => $doctor->experience,
                    'mentors' => $mentorsList ?: 'Менторы не найдены'
                ];
            })
            ->sortBy(['fio', 'experience'])
            ->values();

        return response()->json($doctors);
    }

    /**
     * 10) Занятость врача Иванова И.И. на текущую неделю
     */
    public function query10()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $result = Appointment::select(
                DB::raw("DAYNAME(appointments.datetime) as day_of_week"),
                'appointments.office',
                DB::raw("TIME(appointments.datetime) as appointment_time"),
                'patients.fio as patient_fio'
            )
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id_doctor')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id_patient')
            ->where('doctors.fio', 'Иванов Иван Иванович')
            ->whereBetween('appointments.datetime', [$startOfWeek, $endOfWeek])
            ->orderBy(DB::raw('DAYOFWEEK(appointments.datetime)'))
            ->orderBy('appointment_time')
            ->get();

        return response()->json($result);
    }

    /**
     * Все запросы в одном методе
     */
    public function allQueries()
    {
        return [
            'query1' => $this->query1()->getData(),
            'query2' => $this->query2()->getData(),
            'query3' => $this->query3()->getData(),
            'query4' => $this->query4()->getData(),
            'query5' => $this->query5()->getData(),
            'query6' => $this->query6()->getData(),
            'query7' => $this->query7()->getData(),
            'query8' => $this->query8()->getData(),
            'query9' => $this->query9()->getData(),
            'query10' => $this->query10()->getData(),
        ];
    }

    /**
     * Показать конкретный запрос по номеру
     */
    public function showQuery($number)
    {
        $method = 'query' . $number;
        
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        
        return response()->json(['error' => 'Query not found'], 404);
    }
}