@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <a href="{{ route('tasks.index') }}" class="inline-block mb-4 p-1 bg-amber-50 border border-amber-600 text-amber-600 text-xs rounded-md hover:bg-amber-100"><i class="fa-solid fa-caret-left"></i> Create Task</a>

    <div class="flex items-start gap-4">
        {{-- Create new project --}}
        <form action="{{ route('projects.store') }}" method="post" class="space-y-4 p-4 bg-gray-50 rounded-md">
            @csrf
    
            <div>
                <label for="name" class="block mb-2 text-xs uppercase">Project name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-gray-600" autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
    
            <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700"><i class="fa-solid fa-plus"></i> Add Project</button>
        </form>

        <div class="flex-1">
            @forelse ($projects as $project)
                <div class="flex w-full items-center gap-4 mb-1 p-4 rounded-md border border-gray-300">
                    {{-- Project name --}}
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('tasks.index', ['project' => $project->id]) }}" class="text-gray-600 font-medium">
                            {{ $project->name }}
                        </a>
                    </div>
        
                    {{-- Action buttons --}}
                    <button type="button" onclick="openEditProjectModal({{ $project->id }}, '{{ $project->name }}')" class="text-gray-600 hover:text-amber-600" title="Edit project"><i class="fa-solid fa-pen"></i></button>
                    
                    <form action="{{ route('projects.destroy', $project) }}" method="post" onsubmit="return confirm('Delete this project?')">
                        @csrf
                        @method('DELETE')
        
                        <button type="submit" class="text-gray-600 hover:text-amber-600" title="Delete task"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            @empty
                <p class="text-center italic text-gray-400">Your projects will appear here.</p>
            @endforelse
        </div>
    </div>

    {{-- Edit Project modal --}}
    @include('projects.edit')

@endsection