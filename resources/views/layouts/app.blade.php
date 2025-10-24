<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Медицинская система - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .nav-link {
            color: #333;
            padding: 10px 15px;
            margin: 2px 0;
            border-radius: 5px;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="position-sticky pt-3">
                    <h4 class="text-center mb-4">Медицинская система</h4>
                    <nav class="nav flex-column">
                        @for($i = 1; $i <= 10; $i++)
                            <a class="nav-link {{ request()->is('medical/query' . $i) ? 'active' : '' }}" 
                               href="{{ url('/medical/query' . $i) }}">
                                Запрос {{ $i }}
                            </a>
                        @endfor
                        <a class="nav-link {{ request()->is('medical/all') ? 'active' : '' }}" 
                           href="{{ url('/medical/all') }}">
                            Все запросы
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>
                
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>