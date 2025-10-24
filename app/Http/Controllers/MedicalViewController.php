<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalViewController extends Controller
{
    /**
     * Отображение страницы с запросом 1
     */
    public function showQuery1()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query1()->getData();
        
        return view('medical.query1', [
            'title' => 'Запрос 1 - Пациенты и врачи текущего года',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 2
     */
    public function showQuery2()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query2()->getData();
        
        return view('medical.query2', [
            'title' => 'Запрос 2 - Врачи-терапевты с высокой загруженностью',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 3
     */
    public function showQuery3()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query3()->getData();
        
        return view('medical.query3', [
            'title' => 'Запрос 3 - Статистика посещений по категориям',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 4
     */
    public function showQuery4()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query4()->getData();
        
        return view('medical.query4', [
            'title' => 'Запрос 4 - Врачи той же специальности что и Иванов И.И.',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 5
     */
    public function showQuery5()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query5()->getData();
        
        return view('medical.query5', [
            'title' => 'Запрос 5 - Пациенты не посетившие врачей пациента Иванова',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 6
     */
    public function showQuery6()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query6()->getData();
        
        return view('medical.query6', [
            'title' => 'Запрос 6 - Пациенты-пенсионеры с особыми условиями',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 7
     */
    public function showQuery7()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query7()->getData();
        
        return view('medical.query7', [
            'title' => 'Запрос 7 - Пациенты предпенсионного возраста',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 8
     */
    public function showQuery8()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query8()->getData();
        
        return view('medical.query8', [
            'title' => 'Запрос 8 - Самые загруженные дни прошлого года',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 9
     */
    public function showQuery9()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query9()->getData();
        
        return view('medical.query9', [
            'title' => 'Запрос 9 - Врачи и их менторы',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы с запросом 10
     */
    public function showQuery10()
    {
        $controller = new MedicalQueryController();
        $data = $controller->query10()->getData();
        
        return view('medical.query10', [
            'title' => 'Запрос 10 - Занятость врача Иванова И.И.',
            'data' => $data
        ]);
    }

    /**
     * Отображение страницы со всеми запросами
     */
    public function showAllQueries()
    {
        $controller = new MedicalQueryController();
        $data = $controller->allQueries();
        
        return view('medical.all', [
            'title' => 'Все запросы',
            'data' => $data
        ]);
    }
}