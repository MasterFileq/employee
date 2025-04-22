<?php

namespace App\Http\Controllers;

use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorklogController extends Controller
{
    public function myIndex()
    {
        $worklogs = Auth::user()->worklogs()->latest()->paginate(10);
        return view('worklogs.my_index', compact('worklogs'));
    }

    public function index()
    {
        $worklogs = Worklog::with('user')->latest()->paginate(10);
        return view('worklogs.index', compact('worklogs'));
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'user')->get();
        return view('worklogs.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:24',
            'comment' => 'nullable|string|max:500',
        ]);

        Worklog::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'hours' => $request->hours,
            'comment' => $request->comment,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('manage.worklogs.index')->with('success', 'Wpis dodany.');
    }

    public function edit(Worklog $worklog)
    {
        return view('worklogs.edit', compact('worklog'));
    }

    public function update(Request $request, Worklog $worklog)
    {
        $request->validate([
            'hours' => 'required|numeric|min:0|max:24',
            'comment' => 'nullable|string|max:500',
        ]);

        $worklog->update($request->only('hours', 'comment'));
        return redirect()->route('manage.worklogs.index')->with('success', 'Wpis zaktualizowany.');
    }

    public function destroy(Worklog $worklog)
    {
        $worklog->delete();
        return redirect()->route('manage.worklogs.index')->with('success', 'Wpis usunięty.');
    }
}