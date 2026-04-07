<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareerFlow ATS') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logoicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logoicon.png') }}">
        <script>
            document.documentElement.classList.add('cf-loading');
            (() => {
                const storedTheme = localStorage.getItem('cf-theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const useDark = storedTheme ? storedTheme === 'dark' : prefersDark;

                document.documentElement.classList.toggle('cf-theme-dark', useDark);
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if (! app()->runningUnitTests())
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen overflow-hidden">
            @include('layouts.loading-screen')
            @include('layouts.success-modal')
            @include('layouts.delete-confirm-modal')
            <div class="pointer-events-none absolute inset-x-0 top-[-10rem] h-[28rem] bg-[radial-gradient(circle_at_center,_rgba(212,110,69,0.16),_transparent_62%)]"></div>
            <div class="pointer-events-none absolute right-[-10rem] top-[20rem] h-[22rem] w-[22rem] rounded-full bg-[radial-gradient(circle,_rgba(14,165,233,0.14),_transparent_65%)]"></div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="relative z-10">
                    <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-10 pb-16">
                <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    @if ($errors->any())
                        <div class="cf-panel-soft motion-reveal mt-4 px-5 py-4 text-rose-900" data-motion="hero" data-motion-delay="110">
                            <div class="flex items-start gap-4">
                                <div class="mt-0.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-700">
                                    Fix
                                </div>
                                <div>
                                    <p class="text-sm font-semibold">Please review the highlighted fields and try again.</p>
                                    <ul class="mt-2 space-y-1 text-sm text-rose-800">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
