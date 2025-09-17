<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- TailwindCSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Opcional: favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white shadow p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            {{-- Título da página --}}
            <h1 class="text-2xl font-bold">
                Altri
            </h1>

            {{-- Menu de navegação --}}
            <nav class="space-x-4">
                <a href="{{ route('business-partners.index') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                    Parceiros
                </a>
                <a href="{{ route('contracts.index') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                    Contratos
                </a>
            </nav>
        </div>
    </header>


    {{-- Main content --}}
    <main class="flex-1 max-w-7xl mx-auto p-6 space-y-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }}
    </footer>

</body>

</html>
