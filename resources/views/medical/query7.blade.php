@extends('layouts.app')

@section('title', 'Запрос 7 - Пациенты предпенсионного возраста')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Пациенты предпенсионного возраста (55-60 лет включительно) с особыми условиями посещений</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ФИО пациента</th>
                        <th>Количество посещений</th>
                        <th>Категория</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->visit_count }}</td>
                            <td>
                                <span class="badge {{ $item->category == 'посетил 2 врачей' ? 'bg-info' : 'bg-warning' }}">
                                    {{ $item->category }}
                                </span>
                            </td>
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