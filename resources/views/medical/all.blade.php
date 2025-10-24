@extends('layouts.app')

@section('title', 'Все запросы')

@section('content')
<div class="row">
    @foreach($data as $key => $queryData)
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">{{ $key }}</h6>
            </div>
            <div class="card-body">
                <div style="max-height: 300px; overflow-y: auto;">
                    @if(count($queryData) > 0)
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    @foreach(array_keys((array)$queryData[0]) as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($queryData as $row)
                                    <tr>
                                        @foreach((array)$row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Нет данных</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection