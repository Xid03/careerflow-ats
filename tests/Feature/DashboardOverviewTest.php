<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Company;
use App\Models\Interview;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardOverviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_recent_activity_cards_for_the_authenticated_user(): void
    {
        Carbon::setTestNow('2026-04-02 10:00:00');

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $company = Company::query()->create(['name' => 'CareerFlow Labs']);
        $otherCompany = Company::query()->create(['name' => 'Outside Corp']);

        $application = Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'Backend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        Interview::query()->create([
            'application_id' => $application->id,
            'stage_name' => 'Technical Interview',
            'interview_date' => '2026-04-03 14:00:00',
        ]);

        Reminder::query()->create([
            'application_id' => $application->id,
            'title' => 'Follow up with recruiter',
            'remind_at' => '2026-04-01 09:00:00',
            'is_completed' => false,
        ]);

        $otherApplication = Application::query()->create([
            'user_id' => $otherUser->id,
            'company_id' => $otherCompany->id,
            'job_title' => 'Hidden Role',
            'date_applied' => '2026-04-01',
            'status' => 'Applied',
        ]);

        Interview::query()->create([
            'application_id' => $otherApplication->id,
            'stage_name' => 'Other Interview',
            'interview_date' => '2026-04-03 10:00:00',
        ]);

        Reminder::query()->create([
            'application_id' => $otherApplication->id,
            'title' => 'Hidden reminder',
            'remind_at' => '2026-04-01 09:00:00',
            'is_completed' => false,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response->assertOk();
        $response->assertSeeText('Upcoming Interviews');
        $response->assertSeeText('Overdue Reminders');
        $response->assertSeeText('Status distribution');
        $response->assertSeeText('Monthly application activity');
        $response->assertSeeText('Technical Interview');
        $response->assertSeeText('Follow up with recruiter');
        $response->assertDontSeeText('Outside Corp');
        $response->assertDontSeeText('Hidden reminder');

        Carbon::setTestNow();
    }

    public function test_dashboard_shows_status_and_salary_insights_for_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $company = Company::query()->create(['name' => 'CareerFlow Labs']);
        $otherCompany = Company::query()->create(['name' => 'Outside Corp']);

        Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'Backend Developer',
            'date_applied' => '2026-04-01',
            'status' => 'Offer',
            'expected_salary' => 4000,
            'offered_salary' => 5500,
        ]);

        Application::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'job_title' => 'QA Engineer',
            'date_applied' => '2026-04-02',
            'status' => 'Rejected',
            'expected_salary' => 5000,
        ]);

        Application::query()->create([
            'user_id' => $otherUser->id,
            'company_id' => $otherCompany->id,
            'job_title' => 'Hidden Salary Role',
            'date_applied' => '2026-04-02',
            'status' => 'Offer',
            'expected_salary' => 9000,
            'offered_salary' => 12000,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response->assertOk();
        $response->assertSeeText('Status distribution');
        $response->assertSeeText('Salary snapshot');
        $response->assertSeeText('Offer');
        $response->assertSeeText('Rejected');
        $response->assertSeeText('4,500.00');
        $response->assertSeeText('5,500.00');
        $response->assertDontSeeText('12,000.00');
        $response->assertDontSeeText('Outside Corp');
    }
}
