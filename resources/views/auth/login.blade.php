@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-screen-md">
        <form action="{{ route('login') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-black">
            @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400" for="username">
                Email
            </label>
            <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                    dark:bg-black
                    dark:text-white
                    @error('email')
                    border-red-500
                    @enderror"
                    id="username"
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    value="{{ old('email') }}"
                >

            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400" for="password">
            Password
            </label>
            <input
                class="shadow appearance-none border
                    dark:bg-black
                    dark:text-white
                    @error('password')
                        border-red-500
                    @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="password"
                    id="password"
                    type="password"
                    placeholder="***************"
                >

            @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Login
            </button>

            <a
            href="{{ route('register') }}"
            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 cursor-pointer mt-3">
                Don't have an account?!
            </a>
        </div>


        </form>
    </div>
@endsection
