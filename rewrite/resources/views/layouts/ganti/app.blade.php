<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ 
                 sidebarOpen: window.innerWidth >= 768,
                 logSidebarState() {
                     console.log('📊 [GANTI] Sidebar State:', {
                         open: this.sidebarOpen,
                         timestamp: new Date().toISOString(),
                         screenWidth: window.innerWidth,
                         layout: 'push'
                     });
                 }
             }" 
             @toggle-sidebar.window="sidebarOpen = !sidebarOpen; logSidebarState()" 
             x-init="console.log('🚀 [GANTI] App initialized with sidebar:', sidebarOpen); logSidebarState()"
             class="min-h-screen bg-gray-100 flex">
            @auth
                @include('layouts.sidebar')
            @endauth

            <div class="flex-1 transition-all duration-300 ease-in-out" :class="{ 'md:ml-64': sidebarOpen }">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
