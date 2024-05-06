<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SG Task</title>
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    </head>
    <body>
        <div id="app"></div>
        <script src="{{ Vite::asset('resources/js/app.js') }}"></script>
    </body>
</html>
