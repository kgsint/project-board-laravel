<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="" style="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-200 dark:bg-gray-900 duration-500">
    <div id="app">
        <nav class="bg-white dark:bg-gray-950 shadow-md mb-5">
            <div class="mx-auto max-w-screen-lg px-2 sm:px-6 lg:px-8">
              <div class="relative flex h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <a href="/" class="flex flex-shrink-0 items-center gap-2">
                        <img class="block h-8 w-auto lg:hidden" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                        <img class="hidden h-8 w-auto lg:block" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                        <h1 class=" font-mono dark:text-white">Project Board</h1>
                    </a>
                </div>

                @auth
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="flex justify-center items-center space-x-4 relative ml-3">

                        {{-- theme toggler --}}
                        <x-light-and-dark-btns />


                        <div>
                        {{-- profile dropdown toggler --}}
                        <button
                            id="profile-dropdown-button"
                            type="button"
                            class="flex rounded-full border-2 border-blue-400
                            text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 focus:ring-offset-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="{{ gravatar_url(auth()->user()->email) }}" alt="user's avatar">
                        </button>
                        </div>

                        <div
                            id="profile-dropdown-menu"
                            class=" hidden absolute top-8 right-8 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>

                            <button
                                type="submit"
                                form="logout-form"
                                class="w-full text-left inline-block hover:bg-gray-200 duration-100 px-4 py-2 text-sm">
                                    Logout
                            </button>

                        </div>
                    </div>
                    </div>

                    @else
                    <div class="flex items-center gap-4">

                        {{-- theme toggler --}}
                        <x-light-and-dark-btns />

                        <a
                            href="{{ route('login') }}"
                            class="px-4 py-2 bg-gray-800 hover:bg-gray-600 duration-100 text-white rounded-md"
                        >
                            Login
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="hover:text-gray-500 px-4 py-2 rounded-md hover:bg-gray-600 dark:bg-white dark:text-black duration-100">Register</a>
                    </div>

                @endauth

              </div>
            </div>

          </nav>


        <main class="max-w-screen-lg mx-auto">
            @yield('content')
        </main>
    </div>

    @stack('script')
</body>
</html>

