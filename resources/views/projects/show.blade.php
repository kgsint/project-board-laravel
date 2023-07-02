@extends('layouts.app')

@section('content')
    <header>
        <a
        href="/"
        class="inline-block px-2 py-3 text-xs bg-blue-500 text-white rounded-md mb-4 hover:bg-blue-400 duration-200"
        >
        Go back
        </a>

        <div class="flex justify-between mb-3 bg-gray-100 dark:bg-gray-800  p-3 rounded-lg">
            <h5 class="text-gray-500 dark:text-gray-300">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </h5>

            <div class="flex space-x-4 items-center">
                @foreach ($project->members as $member)
                    <div class="bg-gray-200 dark:bg-gray-900 dark:text-gray-200 rounded-full w-25 p-2 flex justify-center items-baseline gap-1">
                        <img
                            src={{ gravatar_url($member->email) }}
                            alt="{{ $member->name }}"
                            class="rounded-full"
                        >
                        <span class="text-xs">{{  $member->name }}</span>
                    </div>
                @endforeach

                <div class="bg-gray-200 dark:bg-gray-900 dark:text-gray-200 rounded-full w-25 p-2 flex justify-center items-baseline gap-1">
                    <img
                        src={{ gravatar_url($project->user->email) }}
                        alt="{{ $project->user->email }}"
                        class="rounded-full"
                    >
                    <span class="text-xs">{{ $project->user->name }}</span>
                </div>
                <a
                    href="{{ route('projects.edit', $project->id) }}"
                    class="px-2 py-1 bg-blue-400 text-white rounded-md hover:bg-blue-400 hover:text-blue-700 duration-200"
                >
                    Edit
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">

                {{-- tasks --}}
                <div class="mb-6">
                    <h2 class="text-gray-600 mb-1">Tasks</h2>

                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form id="taskUpdateForm" action="{{ route('tasks.update', [$project->id, $task->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="flex justify-between">
                                    <input type="text"
                                        name="body"
                                        class="w-full outline-none focus-visible:border-b-2 focus-visible:border-blue-500
                                        dark:text-white dark:bg-black
                                        @if ($task->completed)
                                            line-through text-gray-700
                                        @endif" value="{{ $task->body }}"
                                    >
                                    <input
                                        onchange="this.form.submit()"
                                        type="checkbox"
                                        class="cursor-pointer focus:ring-2 focus:ring-blue-100 w-5 h-5"
                                        name="completed" {{ $task->completed ? 'checked' : '' }}
                                    />
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card">
                        <form action="{{ $project->path() }}/tasks" method="POST">
                            @csrf

                            <input
                            type="text"
                            placeholder="Add task here"
                            name="body"
                            class="w-full focus-visible:border-b-2 outline-none focus-visible:border-blue-300 dark:text-white dark:bg-black"
                            autocomplete="off"
                            />
                        </form>
                    </div>

                </div>

                {{-- general notes --}}
                <div>
                    <h2 class="text-gray-600 mb-1">General Notes</h2>

                    <div class="card">
                        <form action="" method="post">
                            @csrf
                            @method('PATCH')
                            <textarea
                                name="notes"
                                placeholder="Something to note here..."
                                class="appearance-none border
                                dark:bg-black
                                dark:text-white
                                @error('notes')
                                border-red-500
                                @enderror
                                rounded w-full px-3 text-gray-700 leading-tight
                                focus:outline-none py-2 focus:border focus:border-blue-400 duration-200 focus:shadow-outline" cols="30" rows="4"
                                >{{ $project->notes }}</textarea>

                            @error('notes')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror

                            <button
                                class="bg-blue-400 hover:bg-blue-300 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2">
                <div class="card py-6 flex flex-col space-y-6">
                    <h3 class="text-xl font-semibold -ml-3 border-l-[4px] pl-3 border-l-blue-400">
                        {{ $project->title }}
                    </h3>
                    <p class="text-sm leading-6 text-gray-400 flex-1">
                        {{ $project->description }}
                    </p>
                    @can('manage', $project)
                        {{-- delete project btn --}}
                        <button
                            type="submit"
                            class="text-red-500
                                    text-sm
                                    border border-red-400 p-2
                                    hover:bg-red-500 hover:text-white rounded-md duration-200 ease-in-out"
                            form="deleteProjectForm"
                        >
                            Delete
                        </button>
                    @endcan

                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" id="deleteProjectForm" class="hidden">
                        @method('DELETE')
                        @csrf

                    </form>
                </div>

                {{-- activity log --}}
                <div class="card mt-3">
                        @foreach ($project->activity as $activity)
                            <div class="flex justify-between py-3 {{ !$loop->last ? 'border-b border-gray-400' : '' }}">
                                <x-activity :activity="$activity"></x-activity>
                                <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        @endforeach
                </div>

                @can('manage', $project)
                    {{-- invitation form --}}
                    <div class="card mt-3 space-y-3">
                        <h3 class="text-lg">Invite a user</h3>

                        <form action="{{ route('projects.invite', $project->id) }}" method="POST" id="userInviteForm">
                            @csrf
                        </form>

                        <input
                        form="userInviteForm"
                        type="email"
                        placeholder="Email"
                        name="email"
                        class="w-full border-b-2 border-blue-300 focus-visible:border-b-2
                        outline-none focus-visible:border-blue-400 dark:text-white dark:bg-black"
                        autocomplete="off"
                        />
                        @error('email')
                            <div class="text-xs text-red-500">{{ $message }}</div>
                        @enderror
                        <button
                            form="userInviteForm"
                            class="bg-blue-400 text-xs hover:bg-blue-300 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Invite
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </main>

@endsection

