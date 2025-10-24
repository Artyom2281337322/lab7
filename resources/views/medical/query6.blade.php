@extends('layouts.app')

@section('title', 'Запрос 6 - Пациенты-пенсионеры с особыми условиями')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Пациенты категории «пенсионер», которые в текущем году либо не посещали врача-терапевта, либо посещали неоднократно врача-окулиста</h5>
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
                            <td colspan="2" class="text-center">Нет данных</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection