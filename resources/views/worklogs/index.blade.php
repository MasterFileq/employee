{{-- resources/views/worklogs/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Zarządzanie Godzinami Pracy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('manage.worklogs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                            Dodaj Godziny
                        </a>
                    </div>

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
                        <form method="GET" action="{{ route('manage.worklogs.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 items-end">
                                <div>
                                    <label for="user_id_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pracownik</label>
                                    <select name="user_id_filter" id="user_id_filter"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                        <option value="">Wszyscy</option>
                                        @foreach($filter_users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id_filter') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} (ID: {{ $user->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="date_from_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data od</label>
                                    <input type="date" name="date_from_filter" id="date_from_filter" value="{{ request('date_from_filter') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                </div>
                                <div>
                                    <label for="date_to_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data do</label>
                                    <input type="date" name="date_to_filter" id="date_to_filter" value="{{ request('date_to_filter') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-900 dark:text-gray-300 sm:text-sm">
                                </div>
                                <div>
                                    <label for="comment_search_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Szukaj w komentarzu</label>
                                    <input type="text" name="comment_search_filter" id="comment_search_filter" value="{{ request('comment_search_filter') }}" placeholder="Fragment komentarza..."
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
                                <div class="flex space-x-2 items-end md:col-span-full xl:col-span-1">
                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Filtruj
                                    </button>
                                    <a href="{{ route('manage.worklogs.index') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pracownik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Godziny</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Komentarz</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($worklogs as $worklog)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $worklog->user->name }} <small class="block text-gray-500 dark:text-gray-400">ID: {{ $worklog->user_id }}</small></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $worklog->date->format('d.m.Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $worklog->hours }}</td>
                                        <td class="px-6 py-4 break-words max-w-xs text-sm">{{ $worklog->comment ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($worklog->status === \App\Models\Worklog::STATUS_APPROVED)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                    Zatwierdzony
                                                </span>
                                                @if($worklog->approver) <small class="block text-gray-500 dark:text-gray-400">przez: {{ $worklog->approver->name }}</small>@endif
                                                @if($worklog->approval_comment)<small class="block text-gray-500 dark:text-gray-400 italic" title="{{$worklog->approval_comment}}">Komentarz: {{ Str::limit($worklog->approval_comment, 20) }}</small>@endif
                                            @elseif($worklog->status === \App\Models\Worklog::STATUS_REJECTED)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                                    Odrzucony
                                                </span>
                                                @if($worklog->approver) <small class="block text-gray-500 dark:text-gray-400">przez: {{ $worklog->approver->name }}</small>@endif
                                                @if($worklog->rejection_comment)<small class="block text-gray-500 dark:text-gray-400 italic" title="{{$worklog->rejection_comment}}">Powód: {{ Str::limit($worklog->rejection_comment, 20) }}</small>@endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100">
                                                    Oczekujący
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('manage.worklogs.edit', $worklog) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">Edytuj</a>
                                            
                                            @if($worklog->status === \App\Models\Worklog::STATUS_PENDING || $worklog->status === \App\Models\Worklog::STATUS_REJECTED)
                                                <div class="inline-block" x-data="{ showApprovalComment{{ $worklog->id }}: false }">
                                                    <button type="button" @click="showApprovalComment{{ $worklog->id }} = !showApprovalComment{{ $worklog->id }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-200">Zatwierdź</button>
                                                    <div x-show="showApprovalComment{{ $worklog->id }}" @click.away="showApprovalComment{{ $worklog->id }} = false" x-transition class="mt-2 absolute bg-white dark:bg-gray-700 p-3 rounded shadow-xl z-20 w-64 border dark:border-gray-600">
                                                        <form action="{{ route('manage.worklogs.approve', $worklog) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <label for="approval_comment_{{$worklog->id}}" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Komentarz zatwierdzenia (opcjonalnie):</label>
                                                            <textarea id="approval_comment_{{$worklog->id}}" name="approval_comment" rows="2" class="w-full text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded-md shadow-sm mt-1" placeholder="Opcjonalny komentarz...">{{ old('approval_comment') }}</textarea>
                                                            <button type="submit" class="mt-2 text-xs text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md">Zatwierdź Wpis</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($worklog->status === \App\Models\Worklog::STATUS_PENDING || $worklog->status === \App\Models\Worklog::STATUS_APPROVED)
                                                <div class="inline-block" x-data="{ showRejectionComment{{ $worklog->id }}: false }">
                                                    <button type="button" @click="showRejectionComment{{ $worklog->id }} = !showRejectionComment{{ $worklog->id }}" class="text-orange-600 dark:text-orange-400 hover:text-orange-900 dark:hover:text-orange-200">Odrzuć</button>
                                                    <div x-show="showRejectionComment{{ $worklog->id }}" @click.away="showRejectionComment{{ $worklog->id }} = false" x-transition class="mt-2 absolute bg-white dark:bg-gray-700 p-3 rounded shadow-xl z-20 w-64 border dark:border-gray-600">
                                                        <form action="{{ route('manage.worklogs.reject', $worklog) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <label for="rejection_comment_{{$worklog->id}}" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Powód odrzucenia (wymagany):</label>
                                                            <textarea id="rejection_comment_{{$worklog->id}}" name="rejection_comment" rows="2" class="w-full text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded-md shadow-sm mt-1" placeholder="Powód odrzucenia..." required>{{ old('rejection_comment') }}</textarea>
                                                            @error('rejection_comment') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                                            <button type="submit" class="mt-2 text-xs text-white bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md">Odrzuć Wpis</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <form action="{{ route('manage.worklogs.destroy', $worklog) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200" onclick="return confirm('Czy na pewno chcesz usunąć ten wpis?')">Usuń</button>
                                            </form>
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