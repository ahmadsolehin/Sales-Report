<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.11/css/dataTables.bootstrap5.min.css">

    <style>
        body{
            background:#f3f4f6; 
        }
        .navbar-sales{
            background:#ffffff;
            border-bottom:1px solid #e5e7eb;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-sales">
    <div class="container">
        <a class="navbar-brand fw-semibold text-dark" href="{{ route('report.index') }}">
            Sales Report
        </a>
    </div>
</nav>

<main>
    @yield('content')
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>

@stack('scripts')
</body>
</html>
