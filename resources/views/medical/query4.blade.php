@extends('layouts.app')

@section('title', 'Запрос 4 - Врачи той же специальности что и Иванов И.И.')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Врачи той же специальности что и Иванов И.И. с большим количеством пациентов</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ФИО врача</th>
                        <th>Количество пациентов</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->patient_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Нет данных или врач Иванов И.И. не найден</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection