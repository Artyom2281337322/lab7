<?php

use App\Http\Controllers\MedicalQueryController;
use App\Http\Controllers\MedicalViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/medical/query1');
});

// Маршруты для веб-интерфейса (Blade шаблоны)
Route::prefix('medical')->group(function () {
    Route::get('/query1', [MedicalViewController::class, 'showQuery1']);
    Route::get('/query2', [MedicalViewController::class, 'showQuery2']);
    Route::get('/query3', [MedicalViewController::class, 'showQuery3']);
    Route::get('/query4', [MedicalViewController::class, 'showQuery4']);
    Route::get('/query5', [MedicalViewController::class, 'showQuery5']);
    Route::get('/query6', [MedicalViewController::class, 'showQuery6']);
    Route::get('/query7', [MedicalViewController::class, 'showQuery7']);
    Route::get('/query8', [MedicalViewController::class, 'showQuery8']);
    Route::get('/query9', [MedicalViewController::class, 'showQuery9']);
    Route::get('/query10', [MedicalViewController::class, 'showQuery10']);
    Route::get('/all', [MedicalViewController::class, 'showAllQueries']);
});

// API маршруты (возвращают JSON)
Route::prefix('api/medical')->group(function () {
    Route::get('/query1', [MedicalQueryController::class, 'query1']);
    Route::get('/query2', [MedicalQueryController::class, 'query2']);
    Route::get('/query3', [MedicalQueryController::class, 'query3']);
    Route::get('/query4', [MedicalQueryController::class, 'query4']);
    Route::get('/query5', [MedicalQueryController::class, 'query5']);
    Route::get('/query6', [MedicalQueryController::class, 'query6']);
    Route::get('/query7', [MedicalQueryController::class, 'query7']);
    Route::get('/query8', [MedicalQueryController::class, 'query8']);
    Route::get('/query9', [MedicalQueryController::class, 'query9']);
    Route::get('/query10', [MedicalQueryController::class, 'query10']);
    Route::get('/all', [MedicalQueryController::class, 'allQueries']);
});

// Тестовые маршруты (можно удалить после проверки)
Route::prefix('test')->group(function () {
    Route::get('/query1', function () {
        $data = [
            ['id' => 1, 'fio' => 'Тест Врач 1', 'appointment_count' => 5, 'type' => 'Врач'],
            ['id' => 2, 'fio' => 'Тест Пациент 1', 'appointment_count' => 3, 'type' => 'Пациент']
        ];
        return view('medical.query1', ['title' => 'Тест Запрос 1', 'data' => $data]);
    });
    
    Route::get('/query2', function () {
        $data = [
            ['id' => 1, 'fio' => 'Терапевт Тестовый', 'patient_count' => 6],
            ['id' => 2, 'fio' => 'Терапевт Другой', 'patient_count' => 4]
        ];
        return view('medical.query2', ['title' => 'Тест Запрос 2', 'data' => $data]);
    });
});
// Отладочные маршруты для проблемных запросов
Route::prefix('debug')->group(function () {
    Route::get('/query4', function () {
        $controller = new App\Http\Controllers\MedicalQueryController();
        $data = $controller->query4()->getData();
        
        echo "<h3>Запрос 4 - Данные:</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
        // Проверим специальность Иванова
        $ivanovSpecialty = \App\Models\Doctor::where('fio', 'Иванов Иван Иванович')->value('specialty');
        echo "<h3>Специальность Иванова И.И.: {$ivanovSpecialty}</h3>";
        
        // Проверим количество пациентов Иванова
        $currentYear = now()->year;
        $ivanovPatientCount = \App\Models\Appointment::whereHas('doctor', function($query) {
            $query->where('fio', 'Иванов Иван Иванович');
        })->whereYear('datetime', $currentYear)->count();
        echo "<h3>Количество пациентов Иванова: {$ivanovPatientCount}</h3>";
        
        // Проверим других врачей с той же специальностью
        $otherDoctors = \App\Models\Doctor::where('specialty', $ivanovSpecialty)
            ->where('fio', '<>', 'Иванов Иван Иванович')
            ->get();
        echo "<h3>Другие врачи с той же специальностью:</h3>";
        echo "<pre>";
        print_r($otherDoctors->toArray());
        echo "</pre>";
    });
    
    Route::get('/query7', function () {
        $controller = new App\Http\Controllers\MedicalQueryController();
        $data = $controller->query7()->getData();
        
        echo "<h3>Запрос 7 - Данные:</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
        // Проверим пациентов предпенсионного возраста
        $ageRange = [now()->subYears(60), now()->subYears(55)];
        $preRetirementPatients = \App\Models\Patient::whereBetween('birth_date', [$ageRange[0], $ageRange[1]])->get();
        echo "<h3>Пациенты предпенсионного возраста (55-60 лет):</h3>";
        echo "<pre>";
        print_r($preRetirementPatients->toArray());
        echo "</pre>";
        
        // Проверим их приемы в текущем году
        $currentYear = now()->year;
        foreach ($preRetirementPatients as $patient) {
            $appointments = $patient->appointments()->whereYear('datetime', $currentYear)->get();
            echo "<h4>Приемы пациента {$patient->fio}:</h4>";
            echo "<pre>";
            print_r($appointments->toArray());
            echo "</pre>";
        }
    });
    
    Route::get('/query10', function () {
        $controller = new App\Http\Controllers\MedicalQueryController();
        $data = $controller->query10()->getData();
        
        echo "<h3>Запрос 10 - Данные:</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
        // Проверим существует ли врач Иванов
        $ivanovDoctor = \App\Models\Doctor::where('fio', 'Иванов Иван Иванович')->first();
        echo "<h3>Врач Иванов И.И.:</h3>";
        echo "<pre>";
        print_r($ivanovDoctor ? $ivanovDoctor->toArray() : 'Не найден');
        echo "</pre>";
        
        // Проверим приемы на текущей неделе
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $appointmentsThisWeek = \App\Models\Appointment::whereHas('doctor', function($query) {
            $query->where('fio', 'Иванов Иван Иванович');
        })->whereBetween('datetime', [$startOfWeek, $endOfWeek])->get();
        
        echo "<h3>Приемы Иванова на текущей неделе:</h3>";
        echo "<pre>";
        print_r($appointmentsThisWeek->toArray());
        echo "</pre>";
    });
});