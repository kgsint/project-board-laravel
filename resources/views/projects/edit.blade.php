
@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-screen-md">
        <form
            action="{{ route('projects.update', $project->id) }}"
            method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-black dark:text-white"
        >
            <h2 class="mb-3 text-xl text-center">Edit Project</h2>
            <hr class="mb-3">
            @method('PATCH')
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400" for="title">
                Project Title
                </label>
                <input
                        class="shadow appearance-none border
                        focus:border-blue-400 duration-200
                        rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                        dark:bg-black
                        dark:text-white
                        @error('title')
                        border-red-500
                        @enderror"
                        value="{{ old('title', $project->title) }}"
                        id="title"
                        type="text"
                        name="title"
                        placeholder="Complete the project ...">

                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400" for="description">
            Project's description
            </label>
            <textarea
                name="description"
                class="shadow appearance-none border
                dark:bg-black
                dark:text-white
                @error('description')
                border-red-500
                @enderror
                rounded w-full px-3 text-gray-700 leading-tight
                focus:outline-none py-2 focus:border focus:border-blue-400 duration-200 focus:shadow-outline" id="" cols="30" rows="4"
                >{{old('description', $project->description)}}</textarea>

            @error('description')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Update
            </button>

            <a
                href="{{ $project->path() }}"
                class="bg-white text-black border border-gray-300 font-bold py-2
                px-4 rounded focus:outline-none focus:shadow-outline"
            >
                Cancel
            </a>

        </div>

        </form>
    </div>
@endsection

