@php
    $application = $application ?? null;
@endphp

<div class="space-y-6">
    <section class="cf-panel-soft motion-reveal p-6" data-motion-delay="140">
        <div class="mb-6">
            <p class="cf-kicker text-[var(--cf-muted)]">Core details</p>
            <h3 class="cf-heading mt-2 text-2xl">Role and pipeline information</h3>
            <p class="cf-help mt-2">Start with the company, role, application date, and current status.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="company_name" value="Company name" />
                <x-text-input
                    id="company_name"
                    name="company_name"
                    type="text"
                    class="mt-2 block w-full"
                    :value="old('company_name', $application?->company?->name)"
                    required
                    autofocus
                    placeholder="OpenAI"
                />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="job_title" value="Job title" />
                <x-text-input
                    id="job_title"
                    name="job_title"
                    type="text"
                    class="mt-2 block w-full"
                    :value="old('job_title', $application?->job_title)"
                    required
                    placeholder="Software Engineer"
                />
                <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="date_applied" value="Date applied" />
                <x-text-input
                    id="date_applied"
                    name="date_applied"
                    type="date"
                    class="mt-2 block w-full"
                    :value="old('date_applied', $application?->date_applied?->format('Y-m-d'))"
                    required
                />
                <x-input-error :messages="$errors->get('date_applied')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="status" value="Status" />
                <select
                    id="status"
                    name="status"
                    class="cf-input mt-2 block w-full"
                    required
                >
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $application?->status ?? 'Applied') === $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="status_note" value="Status note" />
                <textarea
                    id="status_note"
                    name="status_note"
                    rows="3"
                    class="cf-input mt-2 block w-full"
                    placeholder="Optional: explain why this status changed, such as 'Recruiter invited me to a technical interview.'"
                >{{ old('status_note') }}</textarea>
                <p class="cf-help mt-2">
                    This note will be saved in the status history when the status changes.
                </p>
                <x-input-error :messages="$errors->get('status_note')" class="mt-2" />
            </div>
        </div>
    </section>

    <section class="cf-panel-soft motion-reveal p-6" data-motion-delay="220">
        <div class="mb-6">
            <p class="cf-kicker text-[var(--cf-muted)]">Compensation and notes</p>
            <h3 class="cf-heading mt-2 text-2xl">Practical details for future decisions</h3>
            <p class="cf-help mt-2">Keep salary expectations, offer details, and context in one place.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="expected_salary" value="Expected salary" />
                <x-text-input
                    id="expected_salary"
                    name="expected_salary"
                    type="number"
                    step="0.01"
                    min="0"
                    class="mt-2 block w-full"
                    :value="old('expected_salary', $application?->expected_salary)"
                    placeholder="4500"
                />
                <x-input-error :messages="$errors->get('expected_salary')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="offered_salary" value="Offered salary" />
                <x-text-input
                    id="offered_salary"
                    name="offered_salary"
                    type="number"
                    step="0.01"
                    min="0"
                    class="mt-2 block w-full"
                    :value="old('offered_salary', $application?->offered_salary)"
                    placeholder="5000"
                />
                <x-input-error :messages="$errors->get('offered_salary')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="job_location" value="Job location" />
                <x-text-input
                    id="job_location"
                    name="job_location"
                    type="text"
                    class="mt-2 block w-full"
                    :value="old('job_location', $application?->job_location)"
                    placeholder="Kuala Lumpur"
                />
                <x-input-error :messages="$errors->get('job_location')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="notes" value="Notes" />
                <textarea
                    id="notes"
                    name="notes"
                    rows="5"
                    class="cf-input mt-2 block w-full"
                    placeholder="Capture where you applied, what stood out about the role, or anything you want to remember later."
                >{{ old('notes', $application?->notes) }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>
        </div>
    </section>
</div>

<div class="motion-reveal mt-8 flex items-center gap-4" data-motion-delay="300">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('applications.index') }}" class="text-sm font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]">
        Cancel
    </a>
</div>
