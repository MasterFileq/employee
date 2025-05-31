<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Główny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="shrink-0 mb-4 sm:mb-0 sm:mr-4">
                            <svg class="h-12 w-12 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Witaj, {{ Auth::user()->name }}!</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Jesteś zalogowany jako: <span class="font-medium text-blue-600 dark:text-blue-400">{{ ucfirst(Auth::user()->role) }}</span>.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">Edytuj swój profil</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @if(Auth::user()->role === 'user')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <svg class="h-8 w-8 text-green-500 dark:text-green-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Dodaj Godziny Pracy</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                                Zarejestruj swoje przepracowane godziny. Twoje wpisy będą oczekiwać na zatwierdzenie.
                            </p>
                            <a href="{{ route('worklogs.createMy') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md transition text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Dodaj Wpis
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Moje Godziny Pracy (dla wszystkich zalogowanych) --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <svg class="h-8 w-8 text-blue-500 dark:text-blue-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Moje Godziny Pracy</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                            Przeglądaj historię swoich wpisów godzin pracy oraz ich status zatwierdzenia.
                        </p>
                        <a href="{{ route('worklogs.myIndex') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition text-sm">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                            </svg>
                            Zobacz Moje Wpisy
                        </a>
                    </div>
                </div>

                {{-- Zarządzanie Godzinami (dla moderatora i admina) --}}
                @if(Auth::user()->role === 'moderator' || Auth::user()->role === 'admin')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <svg class="h-8 w-8 text-purple-500 dark:text-purple-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 9l-3 3m0 0l-3-3m3 3V9" />
                                </svg>
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Zarządzanie Godzinami</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                                Przeglądaj, zatwierdzaj, odrzucaj oraz zarządzaj wpisami godzin pracy wszystkich pracowników. Tutaj możesz również dodać godziny dla innych.
                            </p>
                            <a href="{{ route('manage.worklogs.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-md transition text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                  <path d="M5.433 4.45C6.35 3.57 7.598 3 9 3c1.403 0 2.65.57 3.567 1.45l.598-.598A.75.75 0 0114.25 3.25v3.5a.75.75 0 01-.75.75h-3.5a.75.75 0 01-.53-1.28l.598-.598C9.478 4.42 8.685 4.15 8.022 4.15c-.992 0-1.64.52-1.987 1.073A.75.75 0 015.433 4.45zM18.75 13.25h-3.5a.75.75 0 00-.53 1.28l.598.598C14.522 15.58 15.315 15.85 15.978 15.85c.992 0 1.64-.52 1.987-1.073a.75.75 0 00-.602-1.027l-.598-.598zM15 17H5a2 2 0 01-2-2V7c0-1.1.9-2 2-2h2.25a.75.75 0 000-1.5H5a3.5 3.5 0 00-3.5 3.5v10A3.5 3.5 0 005 19h10a3.5 3.5 0 003.5-3.5V10a.75.75 0 00-1.5 0v4.5a2 2 0 01-2 2zM5 10a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 015 10z" />
                                </svg>
                                Zarządzaj Wpisami
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Zarządzanie Użytkownikami (tylko dla admina) --}}
                @if(Auth::user()->role === 'admin')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <svg class="h-8 w-8 text-red-500 dark:text-red-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-3.741-3.741M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Zarządzanie Użytkownikami</h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-4">
                                Twórz nowe konta użytkowników, edytuj istniejące lub zarządzaj ich uprawnieniami.
                            </p>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                  <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412 indígena.682-4.24A9.953 9.953 0 0010 11.5c-2.478 0-4.723.801-6.535 2.193z" />
                                </svg>
                                Zarządzaj Użytkownikami
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>