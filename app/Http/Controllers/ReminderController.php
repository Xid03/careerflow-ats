<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReminderRequest;
use App\Models\Application;
use App\Models\Reminder;
use Illuminate\Http\RedirectResponse;

class ReminderController extends Controller
{
    public function store(StoreReminderRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $application->reminders()->create([
            'title' => $request->validated('title'),
            'description' => filled($request->validated('description')) ? $request->validated('description') : null,
            'remind_at' => $request->validated('remind_at'),
        ]);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Reminder added successfully.');
    }

    public function complete(Reminder $reminder): RedirectResponse
    {
        $application = $reminder->application;

        $this->authorize('update', $application);

        $reminder->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Reminder marked as completed.');
    }

    public function destroy(Reminder $reminder): RedirectResponse
    {
        $application = $reminder->application;

        $this->authorize('update', $application);

        $reminder->delete();

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Reminder deleted successfully.');
    }
}
