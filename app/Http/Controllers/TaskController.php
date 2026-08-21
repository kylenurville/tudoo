<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    // Opens the index page
    public function index()
    {
        $projects = Project::all();
        $selected_project = request('project') ?? $projects->first()?->id;

        $tasks = Task::where('project_id', $selected_project)->orderBy('position')->get();
        
        return view('tasks.index', compact('projects', 'selected_project', 'tasks'));
    }

    // Saves a task to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:low,medium,high'],
            'project_id' => ['required', 'exists:projects,id']
        ]);

        $task           = new Task();
        $task->name     = $request->name;
        $task->priority = $request->priority;
        $task->position = Task::max('position') + 1;
        $task->project_id = $request->project_id;
        $task->save();

        return back();
    }

    // Updates the position when reordered
    public function reorder(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'task_ids' => ['required', 'array'],
            'task_ids.*' => ['integer', 'exists:tasks,id']
        ]);

        foreach ($request->task_ids as $position => $task_id){
            Task::where('id', $task_id)
                ->where('project_id', $request->project_id)
                ->update(['position' => $position + 1
            ]);
        }

        return response()->noContent();
    }

    // Opens the Edit Task page
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Updates a task
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:low,medium,high']
        ]);

        $task->name     = $request->name;
        $task->priority = $request->priority;
        $task->save();

        return back();
    }

    // Deletes a task from the databse
    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }
}
