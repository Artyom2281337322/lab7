@extends('layouts.app')

@section('title', 'Запрос 9 - Врачи и их менторы')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Врачи без стажа работы или со стажем в 1 год и их возможные менторы</h5>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ФИО врача</th>
                        <th>Специальность</th>
                        <th>Стаж (лет)</th>
                        <th>Возможные менторы</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->specialty }}</td>
                            <td>{{ $item->experience }}</td>
                            <td>{{ $item->mentors }}</td>
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