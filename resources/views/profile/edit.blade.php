<x-app-layout>
    <x-slot name="header">
        <div class="cf-page-header motion-reveal px-6 py-7 sm:px-8 lg:px-10" data-motion="hero">
            <p class="cf-kicker">{{ __('Workspace settings') }}</p>
            <h2 class="cf-heading mt-4 text-4xl leading-[1.05] sm:text-5xl">
                {{ __('Manage your profile and security preferences.') }}
            </h2>
            <p class="cf-help mt-5 max-w-2xl text-base">
                {{ __('Keep your account details current so your workspace stays secure and easy to recognize across demos, screenshots, and everyday use.') }}
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="cf-panel motion-reveal p-6 sm:p-8" data-motion-delay="90">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="cf-panel motion-reveal p-6 sm:p-8" data-motion-delay="150">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="cf-panel motion-reveal p-6 sm:p-8" data-motion-delay="210">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
