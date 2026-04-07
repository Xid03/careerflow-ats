<nav x-data="{ open: false }" class="relative z-30 px-4 pt-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="cf-panel motion-reveal is-visible flex min-h-[78px] items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex items-center gap-5">
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="inline-flex">
                        <x-application-logo />
                    </a>
                </div>

                <div class="hidden rounded-[20px] border border-[var(--cf-border)] bg-[var(--cf-bg-soft)] p-1.5 shadow-sm sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')">
                        {{ __('Applications') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex sm:ms-6">
                <button type="button" data-theme-toggle class="cf-theme-toggle" aria-label="Toggle dark mode">
                    <svg class="cf-theme-toggle__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <circle cx="12" cy="12" r="4.25" />
                        <path d="M12 2.75v2.5M12 18.75v2.5M21.25 12h-2.5M5.25 12h-2.5M18.54 5.46l-1.77 1.77M7.23 16.77l-1.77 1.77M18.54 18.54l-1.77-1.77M7.23 7.23L5.46 5.46" />
                    </svg>
                    <svg class="cf-theme-toggle__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M20.2 14.45A8.5 8.5 0 1 1 9.55 3.8a7.1 7.1 0 0 0 10.65 10.65Z" />
                    </svg>
                    <span class="cf-theme-toggle__label">Dark mode</span>
                </button>

                <a
                    href="{{ route('applications.create') }}"
                    class="cf-button-primary"
                >
                    Add Application
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="cf-toolbar-button inline-flex items-center gap-3 rounded-[18px] px-3.5 py-2.5 text-sm font-medium text-[var(--cf-ink)] focus:outline-none">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[var(--cf-bg-soft)] text-xs font-semibold uppercase tracking-[0.12em] text-[var(--cf-ink)]">
                                {{ \Illuminate\Support\Str::of(Auth::user()->name)->explode(' ')->take(2)->map(fn ($part) => \Illuminate\Support\Str::substr($part, 0, 1))->implode('') }}
                            </div>

                            <div class="text-left">
                                <div class="text-sm font-semibold text-[var(--cf-ink)]">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-[var(--cf-muted)]">Workspace</div>
                            </div>

                            <div class="ms-1 text-[var(--cf-muted)]">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" data-theme-toggle class="cf-theme-toggle me-2" aria-label="Toggle dark mode">
                    <svg class="cf-theme-toggle__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <circle cx="12" cy="12" r="4.25" />
                        <path d="M12 2.75v2.5M12 18.75v2.5M21.25 12h-2.5M5.25 12h-2.5M18.54 5.46l-1.77 1.77M7.23 16.77l-1.77 1.77M18.54 18.54l-1.77-1.77M7.23 7.23L5.46 5.46" />
                    </svg>
                    <svg class="cf-theme-toggle__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M20.2 14.45A8.5 8.5 0 1 1 9.55 3.8a7.1 7.1 0 0 0 10.65 10.65Z" />
                    </svg>
                </button>

                <button @click="open = ! open" class="cf-toolbar-button inline-flex items-center justify-center rounded-2xl p-3 text-[var(--cf-ink)] focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-180"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="sm:hidden"
    >
        <div class="cf-panel mt-3 overflow-hidden px-4 py-4">
            <div class="space-y-2">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')">
                    {{ __('Applications') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('applications.create')" :active="request()->routeIs('applications.create')">
                    {{ __('Add Application') }}
                </x-responsive-nav-link>
            </div>

            <div class="cf-user-card mt-4 rounded-[24px] px-4 py-4">
                <div class="font-semibold text-[var(--cf-ink)]">{{ Auth::user()->name }}</div>
                <div class="text-sm text-[var(--cf-muted)]">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-4 space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
