
@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-screen-md">
        <form action="{{ route('register') }}" method="POST" class="bg-white dark:bg-black shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold dark:text-gray-400 mb-2" for="name">
            Name
            </label>
            <input
                    class="shadow appearance-none dark:bg-black dark:text-white border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                    @error('name')
                    border-red-500
                    @enderror"
                    value="{{ old('name') }}"
                    id="name"
                    type="text"
                    name="name"
                    placeholder="Name">

            @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold dark:text-gray-400 mb-2" for="email">
            Email
            </label>
            <input
                    class="shadow appearance-none dark:bg-black dark:text-white border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                    @error('email')
                    border-red-500
                    @enderror"
                    value="{{ old('email') }}"
                    id="email"
                    type="email"
                    name="email"
                    placeholder="Email Address">

            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold dark:text-gray-400 mb-2" for="password">
            Password
            </label>
            <input
                class="shadow appearance-none dark:bg-black dark:text-white border @error('password')
                    border-red-500
                @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                name="password"
                id="password"
                type="password"
                placeholder="******************">

            @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold dark:text-gray-400 mb-2" for="password-confirmation">
            Confirm Password
            </label>
            <input
                class="shadow appearance-none border dark:bg-black dark:text-white @error('password_confirmation')
                    border-red-500
                @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                name="password_confirmation"
                id="password-confirmation"
                type="password"
                placeholder="******************">

            @error('password_confirmation')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Register
            </button>

            <a
            href="{{ route('login') }}"
            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 cursor-pointer mt-3">
                Already registered?!
            </a>
        </div>

        </form>
    </div>
@endsection

