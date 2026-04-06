<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <p class="cf-kicker">Create entry</p>
            <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">Add a new application to your pipeline.</h2>
            <p class="cf-help mt-5 max-w-2xl text-base">
                Capture the essentials now so your future self always knows what you applied for, where it came from, and what to do next.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <section class="cf-panel motion-reveal p-8" data-motion-delay="90">
                <form method="POST" action="{{ route('applications.store') }}">
                    @csrf

                    @include('applications._form', [
                        'statuses' => $statuses,
                        'submitLabel' => 'Save Application',
                    ])
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
