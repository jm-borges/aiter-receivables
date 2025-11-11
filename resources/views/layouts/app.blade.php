<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/dashboard.css">
    <link rel="stylesheet" href="/assets/styles/operation-execute-index.css">
    <link rel="stylesheet" href="/assets/styles/receivables-query.css">

    <script src="/assets/scripts/query-index/main.js" type="module"></script>
    <script src="/assets/scripts/operation-execute-index/main.js" type="module"></script>
</head>

<body class="font-sans antialiased bg-page-bg">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            @isset($header)
                <header>
                    {{ $header }}
                </header>
            @endisset

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
