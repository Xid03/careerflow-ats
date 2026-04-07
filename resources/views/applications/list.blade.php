<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="cf-kicker">Application library</p>
                    <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">Track every role without losing the thread.</h2>
                    <p class="cf-help mt-5 max-w-xl text-base">
                        Search your pipeline, filter by status, and export a clean snapshot whenever you need a backup or review.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('applications.export', request()->query()) }}"
                        class="cf-button-secondary"
                    >
                        Export CSV
                    </a>
                    <a
                        href="{{ route('applications.create') }}"
                        class="cf-button-primary"
                    >
                        Add Application
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="cf-panel motion-reveal p-6" data-motion-delay="80">
                <form method="GET" action="{{ route('applications.index') }}" class="grid gap-4 md:grid-cols-[2fr_1fr_auto] md:items-end">
                    <div>
                        <x-input-label for="search" value="Search applications" />
                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute inset-y-0 left-0 z-10 inline-flex w-12 items-center justify-center text-[var(--cf-muted)]" aria-hidden="true">
                                <svg class="h-[0.95rem] w-[0.95rem] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="11" cy="11" r="6.5" />
                                    <path d="M16 16l4.5 4.5" />
                                </svg>
                            </span>
                            <x-text-input
                                id="search"
                                name="search"
                                type="text"
                                class="block w-full pl-12"
                                placeholder="Search company or job title"
                                :value="$filters['search'] ?? ''"
                            />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select
                            id="status"
                            name="status"
                            class="cf-input mt-2 block w-full"
                        >
                            <option value="">All statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 md:pb-[0.15rem]">
                        <x-primary-button class="shrink-0">Apply filters</x-primary-button>
                        <a
                            href="{{ route('applications.index') }}"
                            class="inline-flex h-[3.1rem] items-center rounded-2xl px-4 text-sm font-semibold text-[var(--cf-accent)] hover:bg-[rgba(15,118,110,0.08)] hover:text-[var(--cf-accent-deep)]"
                        >
                            Clear
                        </a>
                    </div>
                </form>
            </section>

            <section class="cf-panel motion-reveal overflow-hidden" data-motion-delay="130">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[var(--cf-border)]">
                        <thead class="bg-[rgba(237,243,248,0.78)]">
                            <tr class="text-left text-xs font-semibold uppercase tracking-[0.09em] text-[var(--cf-muted)]">
                                <th class="px-6 py-4">Company</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Applied</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Expected (RM)</th>
                                <th class="px-6 py-4">Offer (RM)</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--cf-border)] text-sm text-[var(--cf-ink)]">
                            @forelse ($applications as $application)
                                <tr class="motion-reveal align-top transition hover:bg-[rgba(15,118,110,0.035)]" data-motion-delay="{{ $loop->index * 55 }}">
                                    <td class="px-6 py-4 font-semibold text-[var(--cf-ink)]">{{ $application->company->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium">{{ $application->job_title }}</div>
                                        @if ($application->job_location)
                                            <div class="cf-help">{{ $application->job_location }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $application->date_applied->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="cf-pill {{ \App\Models\Application::statusBadgeClasses($application->status) }}">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $application->expected_salary ? number_format((float) $application->expected_salary, 2) : 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $application->offered_salary ? number_format((float) $application->offered_salary, 2) : 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('applications.show', $application) }}" class="inline-flex items-center gap-2 rounded-full bg-[rgba(15,118,110,0.1)] px-3 py-1.5 font-semibold text-[var(--cf-accent-deep)] hover:bg-[rgba(15,118,110,0.16)]">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                                                    <circle cx="12" cy="12" r="3.2" stroke-width="1.9" />
                                                </svg>
                                                <span>View</span>
                                            </a>
                                            <a href="{{ route('applications.edit', $application) }}" class="inline-flex items-center gap-2 rounded-full bg-[var(--cf-bg-soft)] px-3 py-1.5 font-semibold text-[var(--cf-ink)] hover:bg-[rgba(15,118,110,0.08)]">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4.75 19.25h4.1l8.96-8.96a1.9 1.9 0 0 0 0-2.69l-1.41-1.41a1.9 1.9 0 0 0-2.69 0l-8.96 8.96v4.1Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12.75 7.25l4 4" />
                                                </svg>
                                                <span>Edit</span>
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route('applications.destroy', $application) }}"
                                                data-confirm-delete
                                                data-confirm-label="Delete application"
                                                data-confirm-title="Delete this application?"
                                                data-confirm-message="This will permanently remove {{ $application->job_title }} at {{ $application->company->name }} from your pipeline."
                                                data-confirm-button="Delete application"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1.5 font-semibold text-rose-700 hover:bg-rose-100">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4.75 7.75h14.5" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9.25 7.75V5.9c0-.64.51-1.15 1.15-1.15h3.2c.64 0 1.15.51 1.15 1.15v1.85" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M7.25 7.75l.73 10.3c.06.83.75 1.47 1.58 1.47h4.88c.83 0 1.52-.64 1.58-1.47l.73-10.3" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10.25 11.25v4.75M13.75 11.25v4.75" />
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No applications found</p>
                                        <p class="cf-help mt-3">Try adjusting your filters or add your first application.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($applications->hasPages())
                    <div class="border-t border-[var(--cf-border)] px-6 py-4">
                        {{ $applications->links() }}
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
