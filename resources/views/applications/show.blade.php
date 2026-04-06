<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="cf-kicker">{{ $application->company->name }}</p>
                    <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">{{ $application->job_title }}</h2>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <span class="cf-pill {{ \App\Models\Application::statusBadgeClasses($application->status) }}">{{ $application->status }}</span>
                        <span class="rounded-full border border-[var(--cf-border)] bg-white px-4 py-2 text-sm text-[var(--cf-muted)]">
                            Applied {{ $application->date_applied->format('d M Y') }}
                        </span>
                        <span class="rounded-full border border-[var(--cf-border)] bg-white px-4 py-2 text-sm text-[var(--cf-muted)]">
                            {{ $application->job_location ?: 'Location not set' }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('applications.edit', $application) }}"
                        class="cf-button-secondary"
                    >
                        Edit
                    </a>
                    <a
                        href="{{ route('applications.index') }}"
                        class="cf-button-primary"
                    >
                        Back to list
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 sm:px-6 lg:grid-cols-[2fr_1fr] lg:px-8">
            <div class="space-y-6">
                <section class="cf-panel motion-reveal p-8" data-motion-delay="80">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Status</p>
                            <p class="mt-3 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ \App\Models\Application::statusBadgeClasses($application->status) }}">
                                {{ $application->status }}
                            </p>
                        </div>

                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Date applied</p>
                            <p class="mt-3 text-lg font-semibold text-[var(--cf-ink)]">{{ $application->date_applied->format('d M Y') }}</p>
                        </div>

                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Expected salary</p>
                            <p class="mt-3 text-lg font-semibold text-[var(--cf-ink)]">
                                {{ $application->expected_salary ? number_format((float) $application->expected_salary, 2) : 'Not set' }}
                            </p>
                        </div>

                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Offered salary</p>
                            <p class="mt-3 text-lg font-semibold text-[var(--cf-ink)]">
                                {{ $application->offered_salary ? number_format((float) $application->offered_salary, 2) : 'Not set' }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="cf-kicker text-[var(--cf-muted)]">Location</p>
                            <p class="mt-3 text-lg font-semibold text-[var(--cf-ink)]">{{ $application->job_location ?: 'Not set' }}</p>
                        </div>
                    </div>
                </section>

                <section class="cf-panel motion-reveal p-8" data-motion-delay="130">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Status history</p>
                            <h3 class="cf-heading mt-2 text-2xl">Application timeline</h3>
                            <p class="cf-help mt-2">
                                Every time the application status changes, it will be recorded here.
                            </p>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $application->statusHistory->count() }} {{ \Illuminate\Support\Str::plural('entry', $application->statusHistory->count()) }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse ($application->statusHistory as $history)
                            <article class="motion-reveal rounded-[24px] border border-[var(--cf-border)] bg-[rgba(255,255,255,0.65)] p-5 shadow-sm" data-motion-delay="{{ $loop->index * 55 }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-lg font-semibold text-[var(--cf-ink)]">
                                            {{ $history->old_status ? $history->old_status.' to '.$history->new_status : 'Initial status: '.$history->new_status }}
                                        </p>
                                        <p class="cf-help mt-1">
                                            {{ $history->changed_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide {{ \App\Models\Application::statusBadgeClasses($history->new_status) }}">
                                        {{ $history->new_status }}
                                    </span>
                                </div>

                                @if ($history->remarks)
                                    <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $history->remarks }}</p>
                                @endif
                            </article>
                        @empty
                            <div class="rounded-[24px] border border-dashed border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-6 py-10 text-center">
                                <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No status changes yet</p>
                                <p class="cf-help mt-3">
                                    Once the application moves through your pipeline, the timeline will appear here.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="cf-panel motion-reveal p-8" data-motion-delay="180">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Interviews</p>
                            <h3 class="cf-heading mt-2 text-2xl">Interview timeline</h3>
                            <p class="cf-help mt-2">
                                This section will list all interview rounds linked to this application.
                            </p>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $application->interviews->count() }} {{ \Illuminate\Support\Str::plural('interview', $application->interviews->count()) }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('applications.interviews.store', $application) }}" class="cf-panel-soft motion-reveal mt-8 p-6" data-motion-delay="220">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="stage_name" value="Stage name" />
                                <x-text-input
                                    id="stage_name"
                                    name="stage_name"
                                    type="text"
                                    class="mt-2 block w-full"
                                    :value="old('stage_name')"
                                    placeholder="Technical Interview"
                                    required
                                />
                                <x-input-error :messages="$errors->get('stage_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="interview_date" value="Interview date and time" />
                                <x-text-input
                                    id="interview_date"
                                    name="interview_date"
                                    type="datetime-local"
                                    class="mt-2 block w-full"
                                    :value="old('interview_date')"
                                />
                                <x-input-error :messages="$errors->get('interview_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mode" value="Mode" />
                                <x-text-input
                                    id="mode"
                                    name="mode"
                                    type="text"
                                    class="mt-2 block w-full"
                                    :value="old('mode')"
                                    placeholder="Video call"
                                />
                                <x-input-error :messages="$errors->get('mode')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="result" value="Result" />
                                <x-text-input
                                    id="result"
                                    name="result"
                                    type="text"
                                    class="mt-2 block w-full"
                                    :value="old('result')"
                                    placeholder="Pending"
                                />
                                <x-input-error :messages="$errors->get('result')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="interview_notes" value="Notes" />
                                <textarea
                                    id="interview_notes"
                                    name="notes"
                                    rows="4"
                                    class="cf-input mt-2 block w-full"
                                    placeholder="What should you prepare or remember for this round?"
                                >{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>Add Interview</x-primary-button>
                        </div>
                    </form>

                    <div class="mt-6 space-y-4">
                        @forelse ($application->interviews as $interview)
                            <article class="motion-reveal rounded-[24px] border border-[var(--cf-border)] bg-[rgba(255,255,255,0.65)] p-5 shadow-sm" data-motion-delay="{{ $loop->index * 55 }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-lg font-semibold text-[var(--cf-ink)]">{{ $interview->stage_name }}</p>
                                        <p class="cf-help mt-1">
                                            {{ $interview->interview_date ? $interview->interview_date->format('d M Y, h:i A') : 'Date not set' }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-2 text-sm">
                                        <span class="rounded-full bg-white px-3 py-1 font-medium text-slate-700">
                                            {{ $interview->mode ?: 'Mode not set' }}
                                        </span>
                                        <span class="rounded-full bg-white px-3 py-1 font-medium text-slate-700">
                                            {{ $interview->result ?: 'Result pending' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-3">
                                    <a
                                        href="{{ route('interviews.edit', $interview) }}"
                                        class="inline-flex items-center rounded-full border border-slate-300 px-3 py-1.5 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-900"
                                    >
                                        Edit interview
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('interviews.destroy', $interview) }}"
                                        data-confirm-delete
                                        data-confirm-label="Delete interview"
                                        data-confirm-title="Delete this interview?"
                                        data-confirm-message="This interview round will be removed from the application timeline."
                                        data-confirm-button="Delete interview"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-full border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-600 transition hover:border-rose-300 hover:text-rose-700"
                                        >
                                            Delete interview
                                        </button>
                                    </form>
                                </div>

                                @if ($interview->notes)
                                    <p class="mt-4 whitespace-pre-line text-sm leading-6 text-[var(--cf-muted)]">{{ $interview->notes }}</p>
                                @endif
                            </article>
                        @empty
                            <div class="rounded-[24px] border border-dashed border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-6 py-10 text-center">
                                <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No interviews yet</p>
                                <p class="cf-help mt-3">
                                    Add your first interview round above to start tracking progress.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="cf-panel motion-reveal p-8" data-motion-delay="230">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="cf-kicker text-[var(--cf-muted)]">Reminders</p>
                            <h3 class="cf-heading mt-2 text-2xl">Follow-up schedule</h3>
                            <p class="cf-help mt-2">
                                This section will show follow-up reminders linked to this application.
                            </p>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $application->reminders->count() }} {{ \Illuminate\Support\Str::plural('reminder', $application->reminders->count()) }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('applications.reminders.store', $application) }}" class="cf-panel-soft motion-reveal mt-8 p-6" data-motion-delay="270">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="reminder_title" value="Reminder title" />
                                <x-text-input
                                    id="reminder_title"
                                    name="title"
                                    type="text"
                                    class="mt-2 block w-full"
                                    :value="old('title')"
                                    placeholder="Follow up with recruiter"
                                    required
                                />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="remind_at" value="Remind date and time" />
                                <x-text-input
                                    id="remind_at"
                                    name="remind_at"
                                    type="datetime-local"
                                    class="mt-2 block w-full"
                                    :value="old('remind_at')"
                                    required
                                />
                                <x-input-error :messages="$errors->get('remind_at')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="reminder_description" value="Description" />
                                <textarea
                                    id="reminder_description"
                                    name="description"
                                    rows="4"
                                    class="cf-input mt-2 block w-full"
                                    placeholder="Add context for the follow-up or what you need to prepare."
                                >{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>Add Reminder</x-primary-button>
                        </div>
                    </form>

                    <div class="mt-6 space-y-4">
                        @forelse ($application->reminders as $reminder)
                            <article class="motion-reveal rounded-[24px] border border-[var(--cf-border)] bg-[rgba(255,255,255,0.65)] p-5 shadow-sm" data-motion-delay="{{ $loop->index * 55 }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-lg font-semibold text-[var(--cf-ink)]">{{ $reminder->title }}</p>
                                        <p class="cf-help mt-1">
                                            Remind at {{ $reminder->remind_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-white px-3 py-1 text-sm font-medium text-slate-700">
                                        {{ $reminder->is_completed ? 'Completed' : 'Pending' }}
                                    </span>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-3">
                                    @unless ($reminder->is_completed)
                                        <form method="POST" action="{{ route('reminders.complete', $reminder) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center rounded-full border border-emerald-200 px-3 py-1.5 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:text-emerald-800"
                                            >
                                                Mark complete
                                            </button>
                                        </form>
                                    @endunless

                                    <form
                                        method="POST"
                                        action="{{ route('reminders.destroy', $reminder) }}"
                                        data-confirm-delete
                                        data-confirm-label="Delete reminder"
                                        data-confirm-title="Delete this reminder?"
                                        data-confirm-message="This follow-up reminder will be permanently removed from the schedule."
                                        data-confirm-button="Delete reminder"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-full border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-600 transition hover:border-rose-300 hover:text-rose-700"
                                        >
                                            Delete reminder
                                        </button>
                                    </form>
                                </div>

                                @if ($reminder->description)
                                    <p class="mt-4 whitespace-pre-line text-sm leading-6 text-[var(--cf-muted)]">{{ $reminder->description }}</p>
                                @endif

                                @if ($reminder->completed_at)
                                    <p class="mt-3 text-xs font-medium uppercase tracking-[0.2em] text-emerald-700">
                                        Completed on {{ $reminder->completed_at->format('d M Y, h:i A') }}
                                    </p>
                                @endif
                            </article>
                        @empty
                            <div class="rounded-[24px] border border-dashed border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-6 py-10 text-center">
                                <p class="font-display text-3xl font-semibold text-[var(--cf-ink)]">No reminders yet</p>
                                <p class="cf-help mt-3">
                                    Add your first follow-up reminder above to stay on top of next steps.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <aside class="cf-panel-dark cf-mesh motion-reveal h-fit p-8 text-white lg:sticky lg:top-28" data-motion-delay="180">
                <p class="cf-kicker text-orange-200">Notes</p>
                <h3 class="cf-heading mt-3 text-3xl text-white">What matters about this opportunity</h3>
                <p class="mt-5 whitespace-pre-line text-sm leading-7 text-slate-200">
                    {{ $application->notes ?: 'No notes added yet.' }}
                </p>
            </aside>
        </div>
    </div>
</x-app-layout>
