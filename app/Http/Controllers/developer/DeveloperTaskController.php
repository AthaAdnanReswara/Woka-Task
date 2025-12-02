<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeveloperTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::where('assigned_to', $user->id)
                     ->with('project', 'assignedTo')
                     ->get();

        return view('developer.task.index', compact('tasks'));
    }

    // Method show detail task
    public function show($id)
    {
        $user = Auth::user();
        $task = Task::where('assigned_to', $user->id)
                    ->with('project', 'assignedTo', 'attachments')
                    ->findOrFail($id);

        return view('developer.task.show', compact('task'));
    }

    // Method update status task
    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('assigned_to', Auth::id())->findOrFail($id);
        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done,cancelled'
        ]);

        $task->status = $request->status;
        $task->save();

        return redirect()->back()->with('success', 'Status task berhasil diperbarui.');
    }
}
