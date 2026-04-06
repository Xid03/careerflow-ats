<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterviewRequest;
use App\Models\Interview;
use App\Http\Requests\UpdateInterviewRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InterviewController extends Controller
{
    public function store(StoreInterviewRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $application->interviews()->create([
            'stage_name' => $request->validated('stage_name'),
            'interview_date' => $request->validated('interview_date'),
            'mode' => filled($request->validated('mode')) ? $request->validated('mode') : null,
            'result' => filled($request->validated('result')) ? $request->validated('result') : null,
            'notes' => filled($request->validated('notes')) ? $request->validated('notes') : null,
        ]);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Interview added successfully.');
    }

    public function edit(Interview $interview): View
    {
        $application = $interview->application;

        $this->authorize('update', $application);

        return view('interviews.edit', [
            'application' => $application,
            'interview' => $interview,
        ]);
    }

    public function update(UpdateInterviewRequest $request, Interview $interview): RedirectResponse
    {
        $application = $interview->application;

        $this->authorize('update', $application);

        $interview->update([
            'stage_name' => $request->validated('stage_name'),
            'interview_date' => $request->validated('interview_date'),
            'mode' => filled($request->validated('mode')) ? $request->validated('mode') : null,
            'result' => filled($request->validated('result')) ? $request->validated('result') : null,
            'notes' => filled($request->validated('notes')) ? $request->validated('notes') : null,
        ]);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Interview updated successfully.');
    }

    public function destroy(Interview $interview): RedirectResponse
    {
        $application = $interview->application;

        $this->authorize('update', $application);

        $interview->delete();

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Interview deleted successfully.');
    }
}
