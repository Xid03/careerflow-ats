<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="cf-kicker">CareerFlow cockpit</p>
                    <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">
                        Your job search, shaped into a clear daily rhythm.
                    </h2>
                    <p class="cf-help mt-5 max-w-xl text-base">
                        See momentum, spot overdue follow-ups, and move each opportunity forward from one calm dashboard.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('applications.create') }}"
                        class="cf-button-primary"
                    >
                        Add Application
                    </a>
                    <a
                        href="{{ route('applications.index') }}"
                        class="cf-button-secondary"
                    >
                        View Pipeline
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ([
                    ['label' => 'Total Applications', 'value' => $stats['total']],
                    ['label' => 'Pending Applications', 'value' => $stats['pending']],
                    ['label' => 'Upcoming Interviews', 'value' => $stats['upcoming_interviews']],
                    ['label' => 'Overdue Reminders', 'value' => $stats['overdue_reminders']],
                    ['label' => 'Offers Received', 'value' => $stats['offers']],
                ] as $card)
                    <article class="cf-panel-soft motion-reveal px-5 py-6" data-motion-delay="{{ $loop->index * 70 }}">
                        <p class="cf-kicker text-[var(--cf-muted)]">{{ $card['label'] }}</p>
                        <p class="mt-4 font-display text-5xl font-semibold text-[var(--cf-ink)]">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
                <article class="cf-panel motion-reveal overflow-hidden" data-motion-delay="80">
                    <div class="flex items-center justify-between border-b border-[var(--cf-border)] px-6 py-5">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Recent pipeline activity</p>
                            <h3 class="cf-heading mt-2 text-2xl">Recent applications</h3>
                            <p class="cf-help mt-2">A quick view of the latest roles in your pipeline.</p>
                        </div>

                        <a href="{{ route('applications.index') }}" class="text-sm font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]">
                            View all
                        </a>
                    </div>

                    <div class="divide-y divide-[var(--cf-border)]">
                        @forelse ($recentApplications as $application)
                            <div class="motion-reveal flex flex-col gap-3 px-6 py-5 sm:flex-row sm:items-center sm:justify-between" data-motion-delay="{{ $loop->index * 70 }}">
                                <div>
                                    <p class="text-lg font-semibold text-[var(--cf-ink)]">{{ $application->job_title }}</p>
                                    <p class="cf-help">
                                        {{ $application->company->name }} | Applied {{ $application->date_applied->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="cf-pill {{ \App\Models\Application::statusBadgeClasses($application->status) }}">
                                        {{ $application->status }}
                                    </span>
                                    <a
                                        href="{{ route('applications.show', $application) }}"
                                        class="text-sm font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]"
                                    >
                                        Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No applications yet</p>
                                <p class="cf-help mt-3">Create your first application to start tracking your search.</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                <div class="space-y-6">
                    <aside class="cf-panel-soft motion-reveal border-rose-200 bg-rose-50/90 p-6" data-motion-delay="140">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="cf-kicker text-rose-600">Needs attention</p>
                                <h3 class="cf-heading mt-2 text-2xl">Overdue reminders</h3>
                            </div>

                            <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-rose-700">
                                {{ $overdueReminders->count() }}
                            </span>
                        </div>

                        <div class="mt-6 space-y-4">
                            @forelse ($overdueReminders as $reminder)
                                <article class="motion-reveal rounded-[24px] border border-rose-200 bg-white p-4 shadow-sm" data-motion-delay="{{ $loop->index * 70 }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-[var(--cf-ink)]">{{ $reminder->title }}</p>
                                            <p class="cf-help mt-1">
                                                {{ $reminder->application->company->name }} | {{ $reminder->application->job_title }}
                                            </p>
                                        </div>

                                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-600">
                                            {{ $reminder->remind_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if ($reminder->description)
                                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $reminder->description }}</p>
                                    @endif

                                    <a
                                        href="{{ route('applications.show', $reminder->application) }}"
                                        class="mt-4 inline-flex items-center text-sm font-semibold text-rose-700 hover:text-rose-800"
                                    >
                                        Open application
                                    </a>
                                </article>
                            @empty
                                <div class="rounded-[24px] border border-dashed border-rose-200 bg-white px-5 py-8 text-center">
                                    <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No overdue reminders</p>
                                    <p class="cf-help mt-3">You're caught up on your follow-ups right now.</p>
                                </div>
                            @endforelse
                        </div>
                    </aside>

                    <aside class="cf-panel-soft motion-reveal border-sky-200 bg-sky-50/90 p-6" data-motion-delay="190">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="cf-kicker text-sky-700">Coming up</p>
                                <h3 class="cf-heading mt-2 text-2xl">Upcoming interviews</h3>
                            </div>

                            <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-sky-700">
                                {{ $upcomingInterviews->count() }}
                            </span>
                        </div>

                        <div class="mt-6 space-y-4">
                            @forelse ($upcomingInterviews as $interview)
                                <article class="motion-reveal rounded-[24px] border border-sky-200 bg-white p-4 shadow-sm" data-motion-delay="{{ $loop->index * 70 }}">
                                    <p class="text-sm font-semibold text-[var(--cf-ink)]">{{ $interview->stage_name }}</p>
                                    <p class="cf-help mt-1">
                                        {{ $interview->application->company->name }} | {{ $interview->application->job_title }}
                                    </p>
                                    <p class="mt-3 text-sm font-medium text-sky-800">
                                        {{ $interview->interview_date->format('d M Y, h:i A') }}
                                    </p>
                                    <p class="mt-1 text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">
                                        {{ $interview->interview_date->diffForHumans() }}
                                    </p>

                                    <a
                                        href="{{ route('applications.show', $interview->application) }}"
                                        class="mt-4 inline-flex items-center text-sm font-semibold text-sky-700 hover:text-sky-800"
                                    >
                                        Open application
                                    </a>
                                </article>
                            @empty
                                <div class="rounded-[24px] border border-dashed border-sky-200 bg-white px-5 py-8 text-center">
                                    <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No upcoming interviews</p>
                                    <p class="cf-help mt-3">Add an interview date to see it appear here.</p>
                                </div>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <article class="cf-panel motion-reveal p-6" data-motion-delay="220">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Pipeline snapshot</p>
                            <h3 class="cf-heading mt-2 text-2xl">Status distribution</h3>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $stats['total'] }} total
                        </span>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-[220px_1fr] md:items-center">
                        <div class="flex items-center justify-center">
                            @if ($statusDistributionStyle)
                                <div
                                    class="motion-reveal motion-donut relative h-52 w-52 rounded-full"
                                    data-motion-delay="300"
                                    style="{{ $statusDistributionStyle }}"
                                >
                                    <div class="absolute inset-[28px] rounded-full bg-white"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <p class="text-3xl font-semibold text-slate-900">{{ $stats['total'] }}</p>
                                            <p class="text-sm text-slate-500">applications</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex h-52 w-52 items-center justify-center rounded-full border border-dashed border-[var(--cf-border)] bg-[var(--cf-bg-soft)] text-center">
                                    <div>
                                        <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No data yet</p>
                                        <p class="cf-help mt-3">Add applications to see your pipeline mix.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @foreach ($statusBreakdown as $status)
                                @php
                                    $percentage = $stats['total'] > 0 ? (int) round(($status['count'] / $stats['total']) * 100) : 0;
                                @endphp

                                <div class="motion-reveal" data-motion-delay="{{ $loop->index * 60 }}">
                                    <div class="flex items-center justify-between gap-3 text-sm">
                                        <div class="flex items-center gap-3">
                                            <span class="h-3 w-3 rounded-full" style="background-color: {{ $status['color'] }}"></span>
                                            <span class="font-medium text-[var(--cf-ink)]">{{ $status['label'] }}</span>
                                        </div>
                                        <p class="cf-help">{{ $status['count'] }} applications | {{ $percentage }}%</p>
                                    </div>

                                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-[var(--cf-bg-soft)]">
                                        <div
                                            class="motion-reveal motion-line-fill h-full rounded-full transition-all {{ \App\Models\Application::statusBarClasses($status['label']) }}"
                                            data-motion-delay="{{ 120 + ($loop->index * 60) }}"
                                            style="width: {{ $percentage }}%;"
                                        ></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>

                <article class="cf-panel-soft motion-reveal border-emerald-200 bg-emerald-50/90 p-6" data-motion-delay="280">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="cf-kicker text-emerald-700">Compensation view</p>
                            <h3 class="cf-heading mt-2 text-2xl">Salary snapshot</h3>
                        </div>

                        <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-emerald-700">
                            {{ $salaryInsights['offer_count'] }} offers tracked
                        </span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="motion-reveal rounded-[24px] border border-emerald-200 bg-white p-5 shadow-sm" data-motion-delay="320">
                            <p class="cf-kicker text-emerald-700">Average expected</p>
                            <p class="mt-3 font-display text-3xl font-semibold text-[var(--cf-ink)]">
                                {{ $salaryInsights['average_expected'] !== null ? number_format($salaryInsights['average_expected'], 2) : 'Not set' }}
                            </p>
                            <p class="cf-help mt-2">
                                From {{ $salaryInsights['expected_count'] }} applications
                            </p>
                        </div>

                        <div class="motion-reveal rounded-[24px] border border-emerald-200 bg-white p-5 shadow-sm" data-motion-delay="390">
                            <p class="cf-kicker text-emerald-700">Average offered</p>
                            <p class="mt-3 font-display text-3xl font-semibold text-[var(--cf-ink)]">
                                {{ $salaryInsights['average_offered'] !== null ? number_format($salaryInsights['average_offered'], 2) : 'Not set' }}
                            </p>
                            <p class="cf-help mt-2">
                                From {{ $salaryInsights['offer_count'] }} offers
                            </p>
                        </div>

                        <div class="motion-reveal rounded-[24px] border border-emerald-200 bg-white p-5 shadow-sm" data-motion-delay="460">
                            <p class="cf-kicker text-emerald-700">Highest offer</p>
                            <p class="mt-3 font-display text-3xl font-semibold text-[var(--cf-ink)]">
                                {{ $salaryInsights['highest_offer'] !== null ? number_format($salaryInsights['highest_offer'], 2) : 'Not set' }}
                            </p>
                            <p class="cf-help mt-2">
                                Best offer currently recorded
                            </p>
                        </div>
                    </div>
                </article>
            </section>

            <section class="cf-panel motion-reveal p-6" data-motion-delay="340">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="cf-kicker text-[var(--cf-muted)]">Momentum</p>
                        <h3 class="cf-heading mt-2 text-2xl">Monthly application activity</h3>
                    </div>

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                        Last 6 months
                    </span>
                </div>

                <div class="mt-8">
                    <div class="flex h-72 items-end justify-between gap-3">
                        @foreach ($monthlyActivity as $month)
                            @php
                                $height = $maxMonthlyActivityCount > 0
                                    ? max(12, (int) round(($month['count'] / $maxMonthlyActivityCount) * 220))
                                    : 12;
                            @endphp

                            <div class="motion-reveal flex flex-1 flex-col items-center gap-3" data-motion-delay="{{ $loop->index * 70 }}">
                                <p class="text-sm font-semibold text-[var(--cf-ink)]">{{ $month['count'] }}</p>
                                <div class="flex h-56 w-full items-end justify-center rounded-[24px] bg-[var(--cf-bg-soft)] px-2 pb-2">
                                    <div
                                        class="motion-reveal motion-bar w-full max-w-16 rounded-[18px] bg-[var(--cf-ink)] transition-all"
                                        data-motion-delay="{{ 180 + ($loop->index * 70) }}"
                                        style="height: {{ $height }}px"
                                        title="{{ $month['full_label'] }}"
                                    ></div>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-[var(--cf-ink)]">{{ $month['label'] }}</p>
                                    <p class="text-xs text-[var(--cf-muted)]">{{ $month['full_label'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
