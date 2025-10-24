@extends('layouts.app')

@section('title', 'Запрос 5 - Пациенты не посетившие врачей пациента Иванова')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Пациенты, не посетившие в текущем году ни одного врача из тех, которых посетил пациент «Иванов С.П.»</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ФИО пациента</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->fio }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Нет данных или пациент Иванов С.П. не найден</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection