<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Company;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReminderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_owner_can_add_a_reminder(): void
    {
        $user = User::factory()->create();
        $company = Company::query()->create([
            'name' => 'CareerFlow Labs',
        ]);

        $application = Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'Junior Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('applications.reminders.store', $application), [
                'title' => 'Follow up with recruiter',
                'description' => 'Send a polite check-in email after one week.',
                'remind_at' => '2026-04-08T09:00',
            ]);

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('reminders', [
            'application_id' => $application->id,
            'title' => 'Follow up with recruiter',
            'is_completed' => 0,
        ]);
    }

    public function test_application_owner_can_complete_a_reminder(): void
    {
        $user = User::factory()->create();
        $company = Company::query()->create([
            'name' => 'CareerFlow Labs',
        ]);

        $application = Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'Junior Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        $reminder = Reminder::query()->create([
            'application_id' => $application->id,
            'title' => 'Follow up with recruiter',
            'remind_at' => '2026-04-08 09:00:00',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('reminders.complete', $reminder));

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('reminders', [
            'id' => $reminder->id,
            'is_completed' => 1,
        ]);
    }

    public function test_application_owner_can_delete_a_reminder(): void
    {
        $user = User::factory()->create();
        $company = Company::query()->create([
            'name' => 'CareerFlow Labs',
        ]);

        $application = Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'Junior Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        $reminder = Reminder::query()->create([
            'application_id' => $application->id,
            'title' => 'Archive this reminder',
            'remind_at' => '2026-04-08 09:00:00',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('reminders.destroy', $reminder));

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseMissing('reminders', [
            'id' => $reminder->id,
        ]);
    }
}
