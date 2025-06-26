<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (isset($header)){{ strip_tags($header->toHtml()) }} - @endif{{ config('app.name', 'SIMPEG') }}</title>

        <link rel="icon" href="{{ asset('images/teamwork.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div 
            x-data="{ 
                sidebarOpen: false, 
                isSidebarMinimized: localStorage.getItem('isSidebarMinimized') === 'true'
            }" 
            x-init="$watch('isSidebarMinimized', value => localStorage.setItem('isSidebarMinimized', value))"
            class="flex h-screen bg-gray-50"
            x-cloak
        >
            <!-- Sidebar -->
            <aside 
                :class="{
                    'w-64': !isSidebarMinimized, 
                    'w-20': isSidebarMinimized,
                    'translate-x-0': sidebarOpen,
                    '-translate-x-full': !sidebarOpen
                }"
                class="fixed inset-y-0 left-0 z-30 flex-shrink-0 overflow-y-auto bg-gray-900 transition-all duration-300 lg:static lg:translate-x-0"
            >
                @include('layouts.sidebar')
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top bar -->
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-500">
                    <div class="flex items-center">
                        <!-- Tombol Buka Sidebar (Mobile) -->
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                        <!-- Tombol Cuitkan Sidebar (Desktop) -->
                        <button @click.stop="isSidebarMinimized = !isSidebarMinimized" class="hidden lg:block text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        @if (isset($header))
                            <div class="relative mx-4 lg:mx-0">
                                {{ $header }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Main content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    <div class="container mx-auto px-6 py-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>