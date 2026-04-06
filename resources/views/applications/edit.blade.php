<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <p class="cf-kicker">Refine details</p>
            <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">Update this application with your latest progress.</h2>
            <p class="cf-help mt-5 max-w-2xl text-base">
                Keep the record current so your dashboard, reminders, and status timeline always reflect the real situation.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <section class="cf-panel motion-reveal p-8" data-motion-delay="90">
                <form method="POST" action="{{ route('applications.update', $application) }}">
                    @csrf
                    @method('PUT')

                    @include('applications._form', [
                        'application' => $application,
                        'statuses' => $statuses,
                        'submitLabel' => 'Update Application',
                    ])
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
