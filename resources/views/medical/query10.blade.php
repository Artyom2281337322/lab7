@extends('layouts.app')

@section('title', 'Запрос 10 - Занятость врача Иванова И.И.')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Занятость врача «Иванов Иван Иванович» на текущую неделю</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>День недели</th>
                        <th>Кабинет</th>
                        <th>Время приема</th>
                        <th>Пациент</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->day_of_week }}</td>
                            <td>{{ $item->office }}</td>
                            <td>{{ $item->appointment_time }}</td>
                            <td>{{ $item->patient_fio }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Нет данных или врач Иванов И.И. не найден</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection