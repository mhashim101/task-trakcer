<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            @include('components.sidebar')


            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Navigation -->
                @include('layouts.navigation')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-4">
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    {{ $slot }}
                </main>
            </div>

            @stack('scripts')
            {{-- <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.img-click').forEach(img => {
                        img.addEventListener('click', function () {
                            console.log('Image clicked:', img.dataset.src);
                            openImageViewer(img.dataset.src);
                        });
                    });
                });

                function openImageViewer(src) {
                    console.log(src);
                    document.getElementById('modalImage').src = src;
                    document.getElementById('downloadImage').href = src + '?download=1';
                    document.getElementById('imageViewerModal').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }

                function closeImageViewer() {
                    document.getElementById('imageViewerModal').classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }

                document.getElementById('imageViewerModal').addEventListener('click', function(e) {
                    if (e.target === this) closeImageViewer();
                });
                </script> --}}
        </div>
    </body>
</html>
