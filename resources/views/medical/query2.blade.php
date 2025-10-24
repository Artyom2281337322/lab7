@extends('layouts.app')

@section('title', 'Запрос 2 - Врачи-терапевты с высокой загруженностью')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Врачи-терапевты с загруженностью > 0.75 в январе прошлого года</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ФИО врача</th>
                        <th>Количество пациентов</th>
                        <th>Загруженность</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->patient_count }}</td>
                            <td>{{ number_format($item->patient_count / 5, 2) }}</td>
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