<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Company;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterviewManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_owner_can_add_an_interview(): void
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
            'status' => 'Interview',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('applications.interviews.store', $application), [
                'stage_name' => 'HR Screening',
                'interview_date' => '2026-04-02T10:30',
                'mode' => 'Video',
                'result' => 'Pending',
                'notes' => 'Prepare intro and availability.',
            ]);

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('interviews', [
            'application_id' => $application->id,
            'stage_name' => 'HR Screening',
            'mode' => 'Video',
            'result' => 'Pending',
        ]);
    }

    public function test_application_owner_can_update_an_interview(): void
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
            'status' => 'Interview',
        ]);

        $interview = Interview::query()->create([
            'application_id' => $application->id,
            'stage_name' => 'HR Screening',
            'interview_date' => '2026-04-02 10:30:00',
            'mode' => 'Video',
            'result' => 'Pending',
            'notes' => 'Prepare intro and availability.',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('interviews.update', $interview), [
                'stage_name' => 'Technical Interview',
                'interview_date' => '2026-04-03T14:00',
                'mode' => 'On-site',
                'result' => 'Shortlisted',
                'notes' => 'Bring portfolio and discuss backend skills.',
            ]);

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseHas('interviews', [
            'id' => $interview->id,
            'stage_name' => 'Technical Interview',
            'mode' => 'On-site',
            'result' => 'Shortlisted',
        ]);
    }

    public function test_application_owner_can_delete_an_interview(): void
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
            'status' => 'Interview',
        ]);

        $interview = Interview::query()->create([
            'application_id' => $application->id,
            'stage_name' => 'Final Interview',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('interviews.destroy', $interview));

        $response->assertRedirect(route('applications.show', $application));

        $this->assertDatabaseMissing('interviews', [
            'id' => $interview->id,
        ]);
    }
}
