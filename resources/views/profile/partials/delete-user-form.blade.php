<section class="space-y-6">
    <header>
        <p class="cf-kicker text-rose-600">
            {{ __('Danger zone') }}
        </p>
        <h2 class="cf-heading mt-2 text-2xl text-[var(--cf-ink)]">
            {{ __('Delete Account') }}
        </h2>

        <p class="cf-help mt-2">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6 p-6 sm:p-8">
            @csrf
            @method('delete')

            <div class="cf-delete-icon-wrap mx-0">
                <span class="cf-delete-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M9 3h6" />
                        <path d="M4 7h16" />
                        <path d="M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12" />
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                    </svg>
                </span>
            </div>

            <div>
                <p class="cf-kicker text-rose-600">{{ __('Delete account') }}</p>
                <h2 class="cf-heading mt-3 text-3xl text-[var(--cf-ink)]">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="cf-help mt-3">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full sm:w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex flex-wrap justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="!rounded-[18px] !px-5 !py-3 !text-sm !font-semibold !normal-case !tracking-normal">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
