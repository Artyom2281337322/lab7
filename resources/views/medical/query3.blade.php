@extends('layouts.app')

@section('title', 'Запрос 3 - Статистика посещений по категориям')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Статистика посещений по категориям пациентов</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Категория пациентов</th>
                        <th>Количество приемов</th>
                        <th>Количество врачей</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->appointment_count }}</td>
                            <td>{{ $item->doctors_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Нет данных</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection