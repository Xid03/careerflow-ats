<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_create_applications(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('applications.store'), [
                'company_name' => 'OpenAI',
                'job_title' => 'Software Engineer',
                'date_applied' => '2026-04-01',
                'status' => 'Applied',
                'status_note' => 'Submitted after tailoring resume to the job description.',
                'expected_salary' => '4500',
                'offered_salary' => null,
                'job_location' => 'Kuala Lumpur',
                'notes' => 'Submitted through company website.',
            ]);

        $application = Application::query()->first();

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('companies', [
            'name' => 'OpenAI',
        ]);

        $this->assertDatabaseHas('applications', [
            'user_id' => $user->id,
            'job_title' => 'Software Engineer',
            'status' => 'Applied',
            'job_location' => 'Kuala Lumpur',
        ]);

        $this->assertDatabaseHas('application_status_histories', [
            'application_id' => $application->id,
            'old_status' => null,
            'new_status' => 'Applied',
            'remarks' => 'Submitted after tailoring resume to the job description.',
        ]);
    }

    public function test_users_only_see_their_own_applications(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $visibleApplication = Application::query()->create([
            'user_id' => $owner->id,
            'company_id' => \App\Models\Company::query()->create(['name' => 'Visible Co'])->id,
            'job_title' => 'Backend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        Application::query()->create([
            'user_id' => $otherUser->id,
            'company_id' => \App\Models\Company::query()->create(['name' => 'Hidden Co'])->id,
            'job_title' => 'Frontend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Interview',
        ]);

        $response = $this
            ->actingAs($owner)
            ->get(route('applications.index'));

        $response->assertOk();
        $response->assertSee($visibleApplication->job_title);
        $response->assertDontSee('Frontend Developer');
        $response->assertDontSee('Hidden Co');
    }

    public function test_status_history_is_recorded_when_application_status_changes(): void
    {
        $user = User::factory()->create();

        $application = Application::query()->create([
            'user_id' => $user->id,
            'company_id' => \App\Models\Company::query()->create(['name' => 'Progress Co'])->id,
            'job_title' => 'Backend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        $application->statusHistory()->create([
            'old_status' => null,
            'new_status' => 'Applied',
            'changed_at' => now()->subDay(),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('applications.update', $application), [
                'company_name' => 'Progress Co',
                'job_title' => 'Backend Developer',
                'date_applied' => '2026-04-01',
                'status' => 'Interview',
                'status_note' => 'Recruiter confirmed the technical round by email.',
                'expected_salary' => null,
                'offered_salary' => null,
                'job_location' => null,
                'notes' => null,
            ]);

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('application_status_histories', [
            'application_id' => $application->id,
            'old_status' => 'Applied',
            'new_status' => 'Interview',
            'remarks' => 'Recruiter confirmed the technical round by email.',
        ]);
    }

    public function test_authenticated_user_can_export_filtered_applications_as_csv(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $visibleCompany = \App\Models\Company::query()->create(['name' => 'Visible Co']);
        $hiddenCompany = \App\Models\Company::query()->create(['name' => 'Hidden Co']);

        Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $visibleCompany->id,
            'job_title' => 'Backend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Interview',
            'job_location' => 'Kuala Lumpur',
            'notes' => 'Prepare for final round.',
        ]);

        Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $visibleCompany->id,
            'job_title' => 'QA Engineer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        Application::query()->create([
            'user_id' => $otherUser->id,
            'company_id' => $hiddenCompany->id,
            'job_title' => 'Hidden Role',
            'date_applied' => '2026-04-01',
            'status' => 'Interview',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('applications.export', ['status' => 'Interview']));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertSeeText('Company');
        $response->assertSeeText('Job Title');
        $response->assertSeeText('Visible Co');
        $response->assertSeeText('Backend Developer');
        $response->assertSeeText('Interview');
        $response->assertSeeText('Kuala Lumpur');
        $response->assertSeeText('Prepare for final round.');
        $response->assertDontSeeText('QA Engineer');
        $response->assertDontSeeText('Hidden Co');
        $response->assertDontSeeText('Hidden Role');
    }

    public function test_application_validation_shows_friendly_message_for_future_date(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('applications.create'))
            ->post(route('applications.store'), [
                'company_name' => 'OpenAI',
                'job_title' => 'Software Engineer',
                'date_applied' => now()->addDay()->format('Y-m-d'),
                'status' => 'Applied',
                'status_note' => null,
                'expected_salary' => null,
                'offered_salary' => null,
                'job_location' => null,
                'notes' => null,
            ]);

        $response->assertRedirect(route('applications.create'));
        $response->assertSessionHasErrors([
            'date_applied' => 'The application date cannot be in the future.',
        ]);
    }
}
