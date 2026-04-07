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
        @php($isCenteredAuth = request()->routeIs('register'))
        @php($showInlineCardLogo = ! request()->routeIs('login', 'password.request'))
        <div class="relative min-h-screen overflow-hidden px-4 py-4 sm:px-6 sm:py-5 lg:px-8 lg:py-6">
            @include('layouts.loading-screen')
            @include('layouts.success-modal')
            <div class="pointer-events-none absolute inset-x-0 top-[-10rem] h-[24rem] bg-[radial-gradient(circle_at_top,_rgba(15,118,110,0.12),_transparent_58%)]"></div>
            <div class="pointer-events-none absolute right-[-6rem] top-[12rem] h-[18rem] w-[18rem] rounded-full bg-[radial-gradient(circle,_rgba(245,158,11,0.08),_transparent_70%)]"></div>

            <div class="relative z-20 mx-auto flex max-w-7xl justify-end">
                <button type="button" data-theme-toggle class="cf-theme-toggle cf-theme-toggle--floating" aria-label="Toggle dark mode">
                    <svg class="cf-theme-toggle__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <circle cx="12" cy="12" r="4.25" />
                        <path d="M12 2.75v2.5M12 18.75v2.5M21.25 12h-2.5M5.25 12h-2.5M18.54 5.46l-1.77 1.77M7.23 16.77l-1.77 1.77M18.54 18.54l-1.77-1.77M7.23 7.23L5.46 5.46" />
                    </svg>
                    <svg class="cf-theme-toggle__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M20.2 14.45A8.5 8.5 0 1 1 9.55 3.8a7.1 7.1 0 0 0 10.65 10.65Z" />
                    </svg>
                    <span class="cf-theme-toggle__label">Dark mode</span>
                </button>
            </div>

            <div @class([
                'relative mx-auto min-h-[calc(100vh-2rem)] items-center',
                'grid max-w-7xl gap-8 lg:grid-cols-[minmax(0,1fr)_28rem] lg:gap-10 xl:gap-14' => ! $isCenteredAuth,
                'flex max-w-lg justify-center' => $isCenteredAuth,
            ])>
                <section class="motion-reveal hidden lg:flex lg:justify-center" data-motion="hero" @if($isCenteredAuth) style="display:none" @endif>
                    <div class="w-full max-w-[32rem]">
                        <a href="{{ route('login') }}" class="inline-flex">
                            <x-application-logo />
                        </a>

                        <p class="cf-kicker mt-8">Simple job tracking</p>
                        <h1 class="cf-heading mt-3 max-w-[13ch] text-4xl leading-[1] xl:text-[3.35rem]">
                            Stay organized through every application.
                        </h1>
                        <p class="cf-help mt-5 max-w-[30rem] text-base sm:text-[1.02rem]">
                            CareerFlow gives job seekers one clean place to manage progress without spreadsheets or scattered notes.
                        </p>

                        <div class="mt-8 max-w-[30rem] space-y-3">
                            <div class="cf-panel-soft flex items-start gap-4 px-5 py-4">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[rgba(15,118,110,0.1)] text-[var(--cf-accent-deep)]">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h10M4 17h16" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-base font-semibold text-[var(--cf-ink)]">Track everything clearly</p>
                                    <p class="cf-help mt-1">Applications, reminders, interviews, salaries, and status history all in one workflow.</p>
                                </div>
                            </div>

                            <div class="cf-panel-soft flex items-start gap-4 px-5 py-4">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[rgba(15,118,110,0.1)] text-[var(--cf-accent-deep)]">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-base font-semibold text-[var(--cf-ink)]">Pick up quickly each day</p>
                                    <p class="cf-help mt-1">See what needs action now and keep your search moving without extra friction.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section @class([
                    'relative flex items-center justify-center',
                    'lg:justify-end' => ! $isCenteredAuth,
                    'w-full' => $isCenteredAuth,
                ])>
                    <div class="w-full max-w-[27.5rem]">
                        <div class="motion-reveal mb-5 is-visible" data-motion="hero" @if(! $showInlineCardLogo || $isCenteredAuth) style="display:none" @endif>
                            <a href="{{ route('login') }}" class="inline-flex">
                                <x-application-logo />
                            </a>
                        </div>

                        <div class="cf-panel overflow-hidden px-6 py-6 sm:px-8 sm:py-7">
                            {{ $slot }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
