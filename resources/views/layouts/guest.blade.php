<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Warung Madura Online') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #222831;
            color: #EEEEEE;
        }
        .card-custom {
            background: #393E46;
            color: #EEEEEE;
            border-radius: 16px;
        }
        .btn-primary-custom {
            background: #00ADB5;
            border: none;
        }
        .btn-primary-custom:hover {
            background: #00939a;
        }
        .text-primary-custom {
            color: #00ADB5;
        }
        .form-control {
            background: #222831;
            border: 1px solid #00ADB5;
            color: #EEEEEE;
        }
        .form-control::placeholder {
            color: #AAAAAA;
        }
    </style>
</head>
<body>

    {{ $slot }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
