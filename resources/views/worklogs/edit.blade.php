<!-- resources/views/worklogs/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edytuj Godziny Pracy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('manage.worklogs.update', $worklog) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Godziny</label>
                            <input type="number" step="0.01" id="hours" name="hours" value="{{ old('hours', $worklog->hours) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                            @error('hours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komentarz</label>
                            <textarea id="comment" name="comment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">{{ old('comment', $worklog->comment) }}</textarea>
                            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                                Zaktualizuj Wpis
                            </button>
                            <a href="{{ route('manage.worklogs.index') }}" class="ml-4 text-gray-500 hover:underline">Anuluj</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>