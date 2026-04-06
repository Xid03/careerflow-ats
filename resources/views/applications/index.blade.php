<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-500">Applications</p>
                <h2 class="text-2xl font-semibold text-slate-900">Track every role in one place</h2>
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
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('applications.index') }}" class="grid gap-4 md:grid-cols-[2fr_1fr_auto]">
                    <div>
                        <x-input-label for="search" value="Search" />
                        <x-text-input
                            id="search"
                            name="search"
                            type="text"
                            class="mt-2 block w-full"
                            placeholder="Search company or job title"
                            :value="$filters['search'] ?? ''"
                        />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select
                            id="status"
                            name="status"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500"
                        >
                            <option value="">All statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <x-primary-button>Filter</x-primary-button>
                        <a href="{{ route('applications.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                            Reset
                        </a>
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-sm font-semibold text-slate-600">
                                <th class="px-6 py-4">Company</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Applied</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Expected</th>
                                <th class="px-6 py-4">Offer</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-700">
                            @forelse ($applications as $application)
                                <tr class="align-top">
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $application->company->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium">{{ $application->job_title }}</div>
                                        @if ($application->job_location)
                                            <div class="text-slate-500">{{ $application->job_location }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $application->date_applied->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-700">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $application->expected_salary ? number_format((float) $application->expected_salary, 2) : '—' }}</td>
                                    <td class="px-6 py-4">{{ $application->offered_salary ? number_format((float) $application->offered_salary, 2) : '—' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('applications.show', $application) }}" class="font-semibold text-slate-700 hover:text-slate-900">View</a>
                                            <a href="{{ route('applications.edit', $application) }}" class="font-semibold text-slate-700 hover:text-slate-900">Edit</a>
                                            <form
                                                method="POST"
                                                action="{{ route('applications.destroy', $application) }}"
                                                data-confirm-delete
                                                data-confirm-label="Delete application"
                                                data-confirm-title="Delete this application?"
                                                data-confirm-message="This will permanently remove {{ $application->job_title }} at {{ $application->company->name }} from your pipeline."
                                                data-confirm-button="Delete application"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-rose-600 hover:text-rose-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <p class="text-lg font-semibold text-slate-900">No applications found</p>
                                        <p class="mt-2 text-sm text-slate-500">Try adjusting your filters or add your first application.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($applications->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $applications->links() }}
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
