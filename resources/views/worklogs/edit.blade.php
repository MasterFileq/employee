{{-- resources/views/worklogs/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edytuj Wpis Godzin Pracy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-700 dark:text-red-100 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $updateRoute = route('manage.worklogs.update', $worklog); 
                        if (Auth::user()->id === $worklog->user_id && !in_array(Auth::user()->role, ['admin', 'moderator'])) {
                            $updateRoute = route('worklogs.updateMy', $worklog);
                        } elseif (request()->routeIs('worklogs.editMy')) {
                            $updateRoute = route('worklogs.updateMy', $worklog);
                        }
                    @endphp

                    <form method="POST" action="{{ $updateRoute }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-md">
                            <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Pracownik:</strong> {{ $worklog->user->name }}</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Data:</strong> {{ $worklog->date->format('d.m.Y') }}</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Aktualny Status:</strong>
                                @if($worklog->status === \App\Models\Worklog::STATUS_APPROVED)
                                    <span class="font-semibold text-green-600 dark:text-green-400">Zatwierdzony</span>
                                @elseif($worklog->status === \App\Models\Worklog::STATUS_REJECTED)
                                    <span class="font-semibold text-red-600 dark:text-red-400">Odrzucony</span>
                                @else
                                    <span class="font-semibold text-yellow-600 dark:text-yellow-400">Oczekujący</span>
                                @endif
                            </p>
                            @if($worklog->status === \App\Models\Worklog::STATUS_REJECTED && $worklog->rejection_comment)
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><strong>Powód odrzucenia:</strong> {{ $worklog->rejection_comment }}</p>
                            @endif
                             @if($worklog->status === \App\Models\Worklog::STATUS_APPROVED && $worklog->approval_comment)
                                <p class="mt-1 text-sm text-green-600 dark:text-green-400"><strong>Komentarz zatwierdzenia:</strong> {{ $worklog->approval_comment }}</p>
                            @endif
                        </div>

                        {{-- Godziny --}}
                        <div class="mt-4">
                            <label for="hours" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Liczba Godzin') }}</label>
                            <input id="hours" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" step="0.1" name="hours" value="{{ old('hours', $worklog->hours) }}" required min="0.1" max="24" />
                            @error('hours') <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Komentarz --}}
                        <div class="mt-4">
                            <label for="comment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Komentarz (opcjonalnie)') }}</label>
                            <textarea id="comment" name="comment" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('comment', $worklog->comment) }}</textarea>
                            @error('comment') <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        @if(Auth::user()->id === $worklog->user_id && $worklog->status === \App\Models\Worklog::STATUS_REJECTED)
                            <p class="mt-4 text-sm text-yellow-700 dark:text-yellow-500 bg-yellow-50 dark:bg-yellow-900 p-3 rounded-md">
                                <span class="font-semibold">Uwaga:</span> Edycja tego odrzuconego wpisu spowoduje zmianę jego statusu z powrotem na "Oczekujący" i usunięcie poprzedniego komentarza odrzucenia.
                            </p>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            @php
                                $cancelRoute = route('manage.worklogs.index');
                                if (request()->routeIs('worklogs.editMy')) {
                                    $cancelRoute = route('worklogs.myIndex');
                                }
                            @endphp
                            <a href="{{ $cancelRoute }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4 underline">
                                {{ __('Anuluj') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Zaktualizuj Wpis') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>