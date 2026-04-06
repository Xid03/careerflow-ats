<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Application::class);

        $filters = request()->only(['search', 'status']);

        $applications = $this->filteredApplicationsQuery($filters)
            ->latest('date_applied')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('applications.list', [
            'applications' => $applications,
            'filters' => $filters,
            'statuses' => Application::statuses(),
        ]);
    }

    public function exportCsv(): Response
    {
        $this->authorize('viewAny', Application::class);

        $filters = request()->only(['search', 'status']);

        $applications = $this->filteredApplicationsQuery($filters)
            ->latest('date_applied')
            ->latest()
            ->get();

        $rows = [
            [
                'Company',
                'Job Title',
                'Date Applied',
                'Status',
                'Expected Salary',
                'Offered Salary',
                'Location',
                'Notes',
            ],
        ];

        foreach ($applications as $application) {
            $rows[] = [
                $application->company->name,
                $application->job_title,
                $application->date_applied->format('Y-m-d'),
                $application->status,
                $application->expected_salary !== null ? number_format((float) $application->expected_salary, 2, '.', '') : '',
                $application->offered_salary !== null ? number_format((float) $application->offered_salary, 2, '.', '') : '',
                $application->job_location ?? '',
                preg_replace("/\r\n|\r|\n/", ' ', $application->notes ?? ''),
            ];
        }

        $stream = fopen('php://temp', 'r+');

        foreach ($rows as $row) {
            fputcsv($stream, $row);
        }

        rewind($stream);
        $csv = stream_get_contents($stream) ?: '';
        fclose($stream);

        $filename = 'careerflow-applications-'.now()->format('Y-m-d').'.csv';

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Application::class);

        return view('applications.create', [
            'statuses' => Application::statuses(),
        ]);
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $this->authorize('create', Application::class);

        $application = $this->persistApplication(new Application(), $request->validated());

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Application added successfully.')
            ->with('success_modal', [
                'label' => 'Pipeline updated',
                'title' => 'Application added.',
                'message' => 'This opportunity is now in your CareerFlow workspace and ready for interviews, reminders, and status tracking.',
                'button' => 'View application',
                'duration' => 3000,
            ]);
    }

    public function show(Application $application): View
    {
        $this->authorize('view', $application);

        $application->load(['company', 'interviews', 'reminders', 'statusHistory']);

        return view('applications.show', [
            'application' => $application,
        ]);
    }

    public function edit(Application $application): View
    {
        $this->authorize('update', $application);

        $application->load('company');

        return view('applications.edit', [
            'application' => $application,
            'statuses' => Application::statuses(),
        ]);
    }

    public function update(UpdateApplicationRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $this->persistApplication($application, $request->validated());

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Application updated successfully.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()
            ->route('applications.index')
            ->with('status', 'Application deleted successfully.');
    }

    private function persistApplication(Application $application, array $validated): Application
    {
        $previousStatus = $application->exists ? $application->getOriginal('status') : null;

        $company = Company::firstOrCreate([
            'name' => $validated['company_name'],
        ]);

        $application->fill([
            'company_id' => $company->id,
            'job_title' => $validated['job_title'],
            'date_applied' => $validated['date_applied'],
            'status' => $validated['status'],
            'expected_salary' => $validated['expected_salary'] ?? null,
            'offered_salary' => $validated['offered_salary'] ?? null,
            'job_location' => filled($validated['job_location']) ? $validated['job_location'] : null,
            'notes' => filled($validated['notes']) ? $validated['notes'] : null,
        ]);

        if (! $application->exists) {
            $application->user_id = (int) auth()->id();
        }

        $application->save();

        if ($previousStatus !== $application->status) {
            $application->statusHistory()->create([
                'old_status' => $previousStatus,
                'new_status' => $application->status,
                'changed_at' => now(),
                'remarks' => filled($validated['status_note'] ?? null) ? $validated['status_note'] : null,
            ]);
        }

        return $application->fresh(['company', 'statusHistory']);
    }

    private function filteredApplicationsQuery(array $filters)
    {
        return Application::query()
            ->ownedBy((int) auth()->id())
            ->with('company')
            ->search($filters['search'] ?? null)
            ->status($filters['status'] ?? null);
    }
}
