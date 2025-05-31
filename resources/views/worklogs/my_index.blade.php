{{-- resources/views/worklogs/my_index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Moje Godziny Pracy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-700 dark:text-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-100 dark:bg-red-700 dark:text-red-100 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Formularz Filtrowania --}}
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                        <form method="GET" action="{{ route('worklogs.myIndex') }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data od</label>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                </div>
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data do</label>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                </div>
                                <div>
                                    <label for="comment_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Szukaj w komentarzu</label>
                                    <input type="text" name="comment_search" id="comment_search" value="{{ request('comment_search') }}" placeholder="Fragment komentarza..."
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                </div>
                                <div>
                                    <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status_filter" id="status_filter"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                        <option value="">Wszystkie</option>
                                        <option value="{{ \App\Models\Worklog::STATUS_PENDING }}" {{ request('status_filter') == \App\Models\Worklog::STATUS_PENDING ? 'selected' : '' }}>Oczekujący</option>
                                        <option value="{{ \App\Models\Worklog::STATUS_APPROVED }}" {{ request('status_filter') == \App\Models\Worklog::STATUS_APPROVED ? 'selected' : '' }}>Zatwierdzony</option>
                                        <option value="{{ \App\Models\Worklog::STATUS_REJECTED }}" {{ request('status_filter') == \App\Models\Worklog::STATUS_REJECTED ? 'selected' : '' }}>Odrzucony</option>
                                    </select>
                                </div>
                                <div class="flex space-x-2 items-end md:col-span-2 lg:col-span-4">
                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Filtruj
                                    </button>
                                    <a href="{{ route('worklogs.myIndex') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Wyczyść
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Godziny</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Komentarz</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Komentarz Decyzji</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($worklogs as $worklog)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $worklog->date->format('d.m.Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $worklog->hours }}</td>
                                        <td class="px-6 py-4 break-words max-w-xs text-sm">{{ $worklog->comment ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($worklog->status === \App\Models\Worklog::STATUS_APPROVED)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                    Zatwierdzony
                                                </span>
                                            @elseif($worklog->status === \App\Models\Worklog::STATUS_REJECTED)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                                    Odrzucony
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100">
                                                    Oczekujący
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 break-words max-w-xs text-sm text-gray-500 dark:text-gray-400">
                                            @if($worklog->status === \App\Models\Worklog::STATUS_REJECTED && $worklog->rejection_comment)
                                                {{ $worklog->rejection_comment }}
                                            @elseif($worklog->status === \App\Models\Worklog::STATUS_APPROVED && $worklog->approval_comment)
                                                {{ $worklog->approval_comment }}
                                            @else
                                                -
                                            @endif
                                             @if($worklog->approver && ($worklog->approval_comment || $worklog->rejection_comment))
                                                <small class="block text-gray-400 dark:text-gray-500">przez: {{ $worklog->approver->name }}</small>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- ZMIANA LINKU EDYCJI --}}
                                            @if(in_array($worklog->status, [\App\Models\Worklog::STATUS_PENDING, \App\Models\Worklog::STATUS_REJECTED]))
                                                <a href="{{ route('worklogs.editMy', $worklog) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">Edytuj</a>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Brak wpisów spełniających kryteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $worklogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>