@extends('layouts.app')

@section('title', 'Запрос 1 - Пациенты и врачи текущего года')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Пациенты и врачи, участвовавшие в приемах в текущем году</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Количество приемов</th>
                        <th>Тип</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->appointment_count }}</td>
                            <td>
                                <span class="badge {{ $item->type == 'Пациент' ? 'bg-primary' : 'bg-success' }}">
                                    {{ $item->type }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Нет данных</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection