@extends('layouts.app')

@section('title', 'Запрос 8 - Самые загруженные дни прошлого года')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Самый загруженный день по месяцам прошлого года</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Месяц</th>
                        <th>Дата</th>
                        <th>Количество посещений</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->month_name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->visit_count }}</td>
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