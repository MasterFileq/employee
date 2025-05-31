<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edytuj Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'profile-updated')
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
                    <span class="font-medium">Sukces!</span> {{ __('Twój profil został zaktualizowany.') }}
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
                    <span class="font-medium">Sukces!</span> {{ __('Twoje hasło zostało zmienione.') }}
                </div>
            @endif


            {{-- Formularz aktualizacji informacji o profilu --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informacje o Profilu') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Zaktualizuj informacje profilowe swojego konta oraz adres e-mail.") }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Imię') }}</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name', 'updateProfileInformation')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email', 'updateProfileInformation')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-gray-200">
                                        {{ __('Twój adres email jest niezweryfikowany.') }}
                                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                            {{ __('Kliknij tutaj, aby ponownie wysłać email weryfikacyjny.') }}
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                            {{ __('Nowy link weryfikacyjny został wysłany na Twój adres email.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">{{ __('Zapisz') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Formularz zmiany hasła --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Zmień Hasło') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Upewnij się, że Twoje konto używa długiego, losowego hasła, aby pozostać bezpiecznym.") }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Aktualne Hasło') }}</label>
                            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" autocomplete="current-password">
                             @error('current_password', 'updatePassword')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password_update" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nowe Hasło') }}</label>
                            <input id="password_update" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" autocomplete="new-password">
                             @error('password', 'updatePassword')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Potwierdź Nowe Hasło') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" autocomplete="new-password">
                             @error('password_confirmation', 'updatePassword')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">{{ __('Zapisz') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Formularz usuwania konta --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Usuń Konto') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Gdy Twoje konto zostanie usunięte, wszystkie jego zasoby i dane zostaną trwale usunięte. Przed usunięciem konta, pobierz wszelkie dane lub informacje, które chcesz zachować.") }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('DELETE')

                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __("Usunięcie konta jest nieodwracalne. Podaj hasło, aby potwierdzić.") }}
                        </p>

                        <div>
                            <label for="password_delete_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300 sr-only">{{ __('Hasło') }}</label>
                            <input id="password_delete_account" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" placeholder="{{ __('Hasło') }}">
                            @error('password', 'userDeletion')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition" onclick="return confirm('{{ __('Czy na pewno chcesz usunąć konto?') }}')">
                                {{ __('Usuń Konto') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</x-app-layout>