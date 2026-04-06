<div
    x-data="{
        show: false,
        form: null,
        title: 'Delete item?',
        message: 'This action cannot be undone.',
        button: 'Delete',
        label: 'Delete confirmation',
        open(detail) {
            this.form = detail.form ?? null;
            this.title = detail.title ?? 'Delete item?';
            this.message = detail.message ?? 'This action cannot be undone.';
            this.button = detail.button ?? 'Delete';
            this.label = detail.label ?? 'Delete confirmation';
            this.show = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.show = false;
            document.body.classList.remove('overflow-hidden');
            this.form = null;
        },
        confirmDelete() {
            if (! this.form) {
                this.close();
                return;
            }

            this.form.dataset.confirmed = 'true';
            document.documentElement.classList.add('cf-loading');
            this.form.submit();
            this.close();
        }
    }"
    x-on:cf-confirm-delete.window="open($event.detail)"
    x-on:keydown.escape.window="show ? close() : null"
    x-cloak
    x-show="show"
    class="cf-delete-overlay"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cf-delete-title"
>
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-220"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-180"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0"
        @click="close()"
    ></div>

    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-280"
        x-transition:enter-start="opacity-0 translate-y-4 scale-[0.97]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-180"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-[0.98]"
        class="cf-panel cf-delete-card"
    >
        <div class="cf-delete-icon-wrap">
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

        <p class="cf-kicker mt-7 text-rose-600" x-text="label"></p>
        <h2 id="cf-delete-title" class="cf-heading mt-3 text-3xl sm:text-4xl" x-text="title"></h2>
        <p class="cf-help mx-auto mt-4 max-w-md" x-text="message"></p>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <button type="button" class="cf-button-secondary" @click="close()">Cancel</button>
            <button type="button" class="cf-button-danger" @click="confirmDelete()" x-text="button"></button>
        </div>
    </div>
</div>
