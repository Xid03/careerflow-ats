<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-500">CareerFlow ATS</p>
                <h2 class="text-2xl font-semibold leading-tight text-slate-900">
                    Your job search dashboard
                </h2>
            </div>

            <a
                href="{{ route('applications.create') }}"
                class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
            >
                Add Application
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['label' => 'Total Applications', 'value' => $stats['total']],
                    ['label' => 'Pending Applications', 'value' => $stats['pending']],
                    ['label' => 'Interview Stage', 'value' => $stats['interviews']],
                    ['label' => 'Offers Received', 'value' => $stats['offers']],
                ] as $card)
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid gap-6 lg:grid-cols-[2fr_1fr]">
                <article class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Recent applications</h3>
                            <p class="text-sm text-slate-500">A quick view of the latest roles in your pipeline.</p>
                        </div>

                        <a href="{{ route('applications.index') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900">
                            View all
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse ($recentApplications as $application)
                            <div class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-lg font-semibold text-slate-900">{{ $application->job_title }}</p>
                                    <p class="text-sm text-slate-500">
                                        {{ $application->company->name }} · Applied {{ $application->date_applied->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">
                                        {{ $application->status }}
                                    </span>
                                    <a
                                        href="{{ route('applications.show', $application) }}"
                                        class="text-sm font-semibold text-slate-700 hover:text-slate-900"
                                    >
                                        Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-lg font-semibold text-slate-900">No applications yet</p>
                                <p class="mt-2 text-sm text-slate-500">Create your first application to start tracking your search.</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                <aside class="rounded-3xl border border-slate-200 bg-slate-900 p-6 text-white shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-300">Day 1 milestone</p>
                    <h3 class="mt-4 text-2xl font-semibold">A strong portfolio foundation</h3>
                    <p class="mt-4 text-sm leading-6 text-slate-300">
                        This first version already demonstrates authentication, SQL relationships, ownership rules,
                        CRUD flow, filtering, and dashboard metrics.
                    </p>

                    <div class="mt-8 space-y-3 text-sm text-slate-200">
                        <p>• Authenticated application tracking</p>
                        <p>• Search and status filtering</p>
                        <p>• Salary and location fields</p>
                        <p>• User-owned records with policies</p>
                    </div>

                    <a
                        href="{{ route('applications.create') }}"
                        class="mt-8 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-200"
                    >
                        Add your first application
                    </a>
                </aside>
            </section>
        </div>
    </div>
</x-app-layout>
