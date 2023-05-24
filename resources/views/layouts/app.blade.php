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
        <link rel="stylesheet" href="https://kit.fontawesome.com/241b76aa5f.css" crossorigin="anonymous">

        <!-- TinyMCE -->
        <script src="https://cdn.tiny.cloud/1/game44tc1m9zkz8bq19ypgre0aibtoxeu7jjkbar3vq32or7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    </head>
    <body class="font-sans antialiased relative">
        <x-banner />

        <div class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-10 lg:w-5/6 lg:m-auto">
                {{ $slot }}
            </main>
            <!-- Page Footer -->
            <footer class="bg-gray-900 w-full absolute bottom-0">
                <div class="py-4">
                    <div class="mx-auto px-4 lg:px-8">
                        <div class="flex justify-between items-center h-8">
                            <div class="flex">
                                <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex text-white text-sm">
                                        {{ __('© 2023 Asuka Method') }}
                                </div>
                                <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex text-white text-sm mx-2">
                                    <a target="_blank" href="//asuka-developer.com">
                                        <i class="fa-regular fa-envelope mx-2"></i>  {{ __('info@asukamethod.com') }}
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
            </footer>

        </div>

        @stack('modals')
        @livewire('livewire-ui-modal')
        @livewireScripts
        <script src="https://kit.fontawesome.com/241b76aa5f.js" crossorigin="anonymous"></script>
    </body>
</html>