@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Project selection and link to project management --}}
    <form action="{{ route('tasks.index') }}" method="get" class="w-full flex gap-4 items-center p-4 rounded-md mb-4 bg-gray-50">
        <select name="project" id="project-id" class="flex-1 text-2xl font-bold focus:outline-none" onchange="this.form.submit()">
            @forelse ($projects as $project)
                <option value="{{ $project->id }}" class="text-base" @selected($project->id == $selected_project)>{{ $project->name }} ({{ $project->tasks->count() }})</option>
            @empty 
                <option value="" hidden>No Projects Found</option>
            @endforelse
        </select>

        <a href="{{ route('projects.index') }}" class="shrink-0 p-1 bg-amber-50 border border-amber-600 text-amber-600 text-xs rounded-md hover:bg-amber-100">Manage Projects <i class="fa-solid fa-caret-right"></i></a>
    </form>

    <div class="flex items-start gap-4">
        {{-- Create new task --}}
        <form action="{{ route('tasks.store') }}" method="post" class="space-y-4 p-4 bg-gray-50 rounded-md">
            @csrf

            <input type="hidden" name="project_id" value="{{ $selected_project }}">

            <div>
                <label for="task-name" class="block mb-2 text-xs uppercase">Task</label>
                <input type="text" name="name" id="task-name" value="{{ old('name') }}" @disabled($projects->isEmpty()) class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-gray-600" autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="priority" class="block mb-2 text-xs uppercase">Priority</label>
                <select name="priority" id="priority" @disabled($projects->isEmpty()) class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-gray-600">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" @disabled($projects->isEmpty()) class="px-4 py-2 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700 disabled:bg-gray-300 disabled:hover:bg-gray-300"><i class="fa-solid fa-plus"></i> Add Task</button>
        </form>
        
        <div id="task-list" class="flex-1">
            @forelse ($tasks as $task)
                <div data-id={{ $task->id }} class="flex w-full items-center gap-4 mb-1 p-4 rounded-md border border-gray-300">
                    {{-- Drag --}}
                    <button class="cursor-grab text-gray-300 active:cursor-grabbing">
                        <i class="fa-solid fa-grip-vertical"></i>
                    </button>

                    {{-- Task name --}}
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-600 font-medium">
                            {{ $task->name }}
                        </p>
                    </div>

                    {{-- Priority --}}
                    <span class="rounded-md px-2 py-1 text-xs font-medium uppercase 
                        @if ($task->priority === 'high')
                            bg-red-100 text-red-700
                        @elseif ($task->priority === 'medium')
                            bg-yellow-100 text-yellow-700
                        @else
                            bg-green-100 text-green-700
                        @endif">
                        {{ $task->priority }}
                    </span>

                    {{-- Action buttons --}}
                    <button type="button" onclick="openEditTaskModal({{ $task->id }}, '{{ $task->name }}', '{{ $task->priority }}')" class="text-gray-600 hover:text-amber-600" title="Edit task"><i class="fa-solid fa-pen"></i></button>

                    <form action="{{ route('tasks.destroy', $task) }}" method="post" onsubmit="return confirm('Delete this task?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-gray-600 hover:text-amber-600" title="Delete task"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            @empty
                <p class="text-center italic text-gray-400">Your tasks will appear here.</p>
            @endforelse
        </div>
    </div>

    {{-- Edit Task modal --}}
    @include('tasks.edit')

@endsection

{{-- SortableJS --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

    <style>
    .sortable-ghost {
        background-color: #F3F4F6;
    }
</style>

    <script>
        const taskList = document.getElementById('task-list');

        new Sortable(taskList, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.cursor-grab',
            onEnd: function(){
                const taskIds = [...taskList.children].map(task => task.dataset.id);

                fetch('{{ route('tasks.reorder') }}', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        project_id: {{ $selected_project }},
                        task_ids: taskIds
                    })
                });
            }
        })
    </script>
@endsection