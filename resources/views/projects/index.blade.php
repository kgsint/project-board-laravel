@extends('layouts.app')

@section('content')
    <header>
        <div class="flex justify-between mb-3 bg-gray-100 dark:bg-gray-800 p-3 rounded-lg">
            <h5 class="text-gray-500 dark:text-gray-400">
                My Projects
            </h5>
            <a
                href="{{ route('projects.create') }}"
                class="px-2 py-1 bg-blue-400 text-white rounded-md ease hover:opacity-100 opacity-80 duration-300 dark:opacity-100"
            >
                Create new project
            </a>
        </div>
    </header>

        @if (session('status'))
            <div id="flash-message" class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                {{ session('status') }}
          </div>
        @endif

    <div class="flex items-center flex-wrap gap-4">
        {{-- looping projects --}}
        @forelse ($projects as $project)
            <div class="card md:w-[300px] md:h-52 relative">
                    <h3 class="text-xl -ml-3 border-l-[4px] pl-3 border-l-blue-400 font-semibold pb-4">
                            <a href="{{ route('projects.show', $project->id) }}" class="hover:underline duration-150">{{ $project->title }}</a>
                    </h3>
                <div class="text-sm text-gray-600 leading-7 dark:text-gray-400">
                    {{ Str::limit($project->description) }}
                </div>

                {{-- authorize view --}}
                @can('manage', $project)
                    <form
                        id="delete-form"
                        action="{{ route('projects.destroy', $project->id) }}"
                        method="POST"
                        class="block text-right absolute bottom-2 right-2"
                    >
                    @method('DELETE')
                    @csrf
                        <button
                            onclick="confirm('Are you sure you want to delete this?')"
                            class=" delete-project-btn text-sm text-red-500"
                        data-id="{{ $project->id }}">Delete</button>
                    </form>
                @endcan
            </div>
        @empty

        @endforelse
    </div>

@endsection
