<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="cf-kicker">{{ $application->company->name }}</p>
                    <h2 class="cf-heading mt-4 text-4xl">Edit interview details</h2>
                    <p class="cf-help mt-4 max-w-2xl text-base">
                        Keep the interview timeline clear so you always know what happened, what is next, and how to prepare.
                    </p>
                </div>

                <a
                    href="{{ route('applications.show', $application) }}"
                    class="cf-button-primary"
                >
                    Back to application
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <section class="cf-panel motion-reveal p-8" data-motion-delay="90">
                <div>
                    <p class="cf-kicker text-[var(--cf-muted)]">Interview round</p>
                    <h3 class="cf-heading mt-2 text-2xl">{{ $interview->stage_name }}</h3>
                    <p class="cf-help mt-2">
                        Update the details for this interview round and save when you're ready.
                    </p>
                </div>

                <form method="POST" action="{{ route('interviews.update', $interview) }}" class="mt-8">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <x-input-label for="stage_name" value="Stage name" />
                            <x-text-input
                                id="stage_name"
                                name="stage_name"
                                type="text"
                                class="mt-2 block w-full"
                                :value="old('stage_name', $interview->stage_name)"
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
                                :value="old('interview_date', $interview->interview_date?->format('Y-m-d\\TH:i'))"
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
                                :value="old('mode', $interview->mode)"
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
                                :value="old('result', $interview->result)"
                                placeholder="Pending"
                            />
                            <x-input-error :messages="$errors->get('result')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="notes" value="Notes" />
                            <textarea
                                id="notes"
                                name="notes"
                                rows="5"
                                class="cf-input mt-2 block w-full"
                                placeholder="Capture what happened, what to prepare next, or who you met."
                            >{{ old('notes', $interview->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <x-primary-button>Save Changes</x-primary-button>

                        <a
                            href="{{ route('applications.show', $application) }}"
                            class="cf-button-secondary"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
