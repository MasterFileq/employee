{{-- resources/views/auth/confirm-password.blade.php --}}
<x-guest-layout>
    {{-- Zastosowano kolor tekstu drugorzędnego --}}
    <div class="mb-4 text-sm text-welcome-text-secondary-light dark:text-welcome-text-secondary-dark">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            {{-- Zakładamy, że <x-input-label> i <x-text-input> zostaną ostylowane wewnętrznie --}}
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            {{-- Zakładamy, że <x-primary-button> zostanie ostylowany wewnętrznie --}}
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
