<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rejestr Pracowników') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 text-center">
            <div class="flex justify-center mb-6">
                <svg class="h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5m-2-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Witaj w Rejestrze Pracowników
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Zarządzaj godzinami pracy, przeglądaj historię i kontroluj dane pracowników w prosty i nowoczesny sposób.
            </p>

            <div class="flex justify-center space-x-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                        Zaloguj się
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-md transition">
                        Zarejestruj się
                    </a>
                @endif
            </div>

            @auth
                <div class="mt-8">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Jesteś już zalogowany jako {{ ucfirst(Auth::user()->role) }}.
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                        Przejdź do Panelu Głównego
                    </a>
                </div>
            @endauth
        </div>

        <footer class="mt-12 text-gray-500 dark:text-gray-400 text-sm">
            &copy; 2025 Łukasz Szczygielski, Grzegorz Sosna, Wiktor Pawłowski. Wszystkie prawa zastrzeżone.
        </footer>
    </div>
</body>
</html>