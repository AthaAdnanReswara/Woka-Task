<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DeveloperTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Tampilkan semua task yang ditugaskan ke developer ini
        $tasks = Task::where('assigned_to', $user->id)->get();

        return view('developer.task.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = Task::where('id', $id)
                    ->where('assigned_to', Auth::id())
                    ->firstOrFail();

        return view('developer.task.show', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)
                    ->where('assigned_to', Auth::id())
                    ->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,progress,completed',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $task->update([
            'status' => $request->status,
            'progress' => $request->progress ?? $task->progress,
        ]);

        return redirect()->route('developer.task.index')->with('success', 'Task updated successfully.');
    }
}
