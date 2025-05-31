<?php

namespace App\Http\Controllers;

use App\Models\Worklog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WorklogController extends Controller
{
    /**
     * Wyświetla listę czasów pracy dla zalogowanego użytkownika z możliwością filtrowania.
     */
    public function myIndex(Request $request)
    {
        $user = Auth::user();
        $query = $user->worklogs()->with('approver');

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        if ($request->filled('comment_search')) {
            $searchTerm = '%' . $request->comment_search . '%';
            $query->where('comment', 'LIKE', $searchTerm);
        }
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        $worklogs = $query->orderBy('date', 'desc')->paginate(15)->appends($request->query());

        return view('worklogs.my_index', compact('worklogs'));
    }

    /**
     * Wyświetla listę wszystkich czasów pracy do zarządzania przez admina/moderatora z filtrowaniem.
     */
    public function index(Request $request)
    {
        $query = Worklog::with(['user', 'approver']);

        if ($request->filled('user_id_filter')) {
            $query->where('user_id', $request->user_id_filter);
        }
        if ($request->filled('date_from_filter')) {
            $query->where('date', '>=', $request->date_from_filter);
        }
        if ($request->filled('date_to_filter')) {
            $query->where('date', '<=', $request->date_to_filter);
        }
        if ($request->filled('comment_search_filter')) {
            $searchTerm = '%' . $request->comment_search_filter . '%';
            $query->where('comment', 'LIKE', $searchTerm);
        }
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        $worklogs = $query->orderBy('date', 'desc')->paginate(15)->appends($request->query());
        $filter_users = User::orderBy('name')->get();

        return view('worklogs.index', compact('worklogs', 'filter_users'));
    }

    /**
     * Wyświetla formularz do tworzenia nowego czasu pracy przez admina/moderatora.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('worklogs.create', compact('users'));
    }

    /**
     * Zapisuje nowy czas pracy w bazie danych.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0.1|max:24',
            'comment' => 'nullable|string|max:500',
        ]);

        $creator = Auth::user();

        $status = Worklog::STATUS_APPROVED;
        $approvedBy = $creator->id;
        $approvedAt = now();
        $approvalComment = ''; // tutaj można domyślny komentarz dodać przy dodaniu czasu przez Administratora lub Moderatora

        Worklog::create([
            'user_id' => $validatedData['user_id'],
            'date' => $validatedData['date'],
            'hours' => $validatedData['hours'],
            'comment' => $validatedData['comment'],
            'created_by' => $creator->id,
            'status' => $status,
            'approved_by' => $approvedBy,
            'approved_at' => $approvedAt,
            'approval_comment' => $approvalComment,
            'rejection_comment' => null,
        ]);

        return redirect()->route('manage.worklogs.index')->with('success', 'Wpis dodany i automatycznie zatwierdzony.');
    }

    /**
     * Wyświetla formularz dla pracownika do dodania swojego czasu pracy.
     */
    public function createMyWorklogForm()
    {
        return view('worklogs.create_my_worklog');
    }

    /**
     * Zapisuje nowy czas pracy dodany przez pracownika (dla samego siebie).
     */
    public function storeMyWorklog(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0.1|max:24',
            'comment' => 'nullable|string|max:500',
        ]);

        $creator = Auth::user();

        Worklog::create([
            'user_id' => $creator->id,
            'date' => $validatedData['date'],
            'hours' => $validatedData['hours'],
            'comment' => $validatedData['comment'],
            'created_by' => $creator->id,
            'status' => Worklog::STATUS_PENDING,
            'approved_by' => null,
            'approved_at' => null,
            'approval_comment' => null,
            'rejection_comment' => null,
        ]);

        return redirect()->route('worklogs.myIndex')->with('success', 'Twój wpis został dodany i oczekuje na zatwierdzenie.');
    }

    /**
     * Wyświetla formularz do edycji czas pracy.
     */
    public function edit(Worklog $worklog)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'moderator']) &&
            !($user->id === $worklog->user_id && in_array($worklog->status, [Worklog::STATUS_PENDING, Worklog::STATUS_REJECTED]))) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do edycji tego wpisu lub wpis nie jest w odpowiednim stanie.');
        }
        return view('worklogs.edit', compact('worklog'));
    }

    /**
     * Aktualizuje istniejący czas pracy.
     */
    public function update(Request $request, Worklog $worklog)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'moderator']) &&
            !($user->id === $worklog->user_id && in_array($worklog->status, [Worklog::STATUS_PENDING, Worklog::STATUS_REJECTED]))) {
            return redirect()->route($user->role === 'user' ? 'worklogs.myIndex' : 'manage.worklogs.index')
                         ->with('error', 'Nie możesz edytować tego wpisu.');
        }

        $validatedData = $request->validate([
            'hours' => 'required|numeric|min:0.1|max:24',
            'comment' => 'nullable|string|max:500',
        ]);
        
        if ($user->id === $worklog->user_id && $worklog->status === Worklog::STATUS_REJECTED) {
             $worklog->status = Worklog::STATUS_PENDING;
             $worklog->rejection_comment = null;
             $worklog->approval_comment = null;
             $worklog->approved_by = null;
             $worklog->approved_at = null;
        }
        
        $worklog->update($validatedData);
        if ($worklog->isDirty('status')) {
            $worklog->save();
        }

        if (in_array($user->role, ['admin', 'moderator'])) {
            return redirect()->route('manage.worklogs.index')->with('success', 'Wpis zaktualizowany pomyślnie.');
        } else {
            $message = 'Wpis zaktualizowany.';
            if ($worklog->status === Worklog::STATUS_PENDING) {
                $message .= ' Oczekuje na zatwierdzenie.';
            }
            return redirect()->route('worklogs.myIndex')->with('success', $message);
        }
    }

    /**
     * Usuwa czas pracy.
     */
    public function destroy(Worklog $worklog)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'moderator']) &&
            !($user->id === $worklog->user_id && in_array($worklog->status, [Worklog::STATUS_PENDING, Worklog::STATUS_REJECTED]))) {
             return redirect()->back()->with('error', 'Nie masz uprawnień do usunięcia tego wpisu.');
        }

        $worklog->delete();

        if (Str::contains(url()->previous(), '/manage/worklogs')) {
             return redirect()->route('manage.worklogs.index')->with('success', 'Wpis usunięty pomyślnie.');
        }
        return redirect()->route('worklogs.myIndex')->with('success', 'Wpis usunięty pomyślnie.');
    }

    /**
     * Zatwierdza czas pracy, dostępne dla admina/moderatora
     */
    public function approve(Request $request, Worklog $worklog)
    {
        $request->validate([
            'approval_comment' => 'nullable|string|max:500',
        ]);

        $worklog->update([
            'status' => Worklog::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_comment' => $request->approval_comment,
            'rejection_comment' => null,
        ]);

        return redirect()->back()->with('success', 'Wpis został zatwierdzony.');
    }

    /**
     * Odrzuca czas pracy, dostępne dla admina/moderatora
     */
    public function reject(Request $request, Worklog $worklog)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:500',
        ]);

        $worklog->update([
            'status' => Worklog::STATUS_REJECTED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_comment' => $request->rejection_comment,
            'approval_comment' => null,
        ]);

        return redirect()->back()->with('success', 'Wpis został odrzucony.');
    }
}