<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PortfolioDemoSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = User::query()->updateOrCreate(
            ['email' => 'demo@careerflow.test'],
            [
                'name' => 'CareerFlow Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        Application::query()->where('user_id', $demoUser->id)->delete();

        $companies = collect([
            'Nimbus Tech',
            'Atlas Systems',
            'BlueOrbit Labs',
            'Horizon Works',
            'Northwind Data',
            'Pixel Forge',
        ])->mapWithKeys(fn (string $name) => [
            $name => Company::query()->firstOrCreate(['name' => $name]),
        ]);

        $applications = [
            [
                'company' => 'Nimbus Tech',
                'job_title' => 'Junior Backend Developer',
                'date_applied' => Carbon::parse('2026-03-10'),
                'status' => 'Interview',
                'expected_salary' => 4200,
                'offered_salary' => null,
                'job_location' => 'Kuala Lumpur',
                'notes' => 'Applied through company website after tailoring backend project portfolio.',
                'history' => [
                    [null, 'Applied', '2026-03-10 09:30:00', 'Submitted resume and GitHub portfolio.'],
                    ['Applied', 'Screening', '2026-03-14 11:00:00', 'Recruiter requested availability and salary expectations.'],
                    ['Screening', 'Interview', '2026-03-18 16:20:00', 'Technical interview scheduled for next week.'],
                ],
                'interviews' => [
                    ['stage_name' => 'Recruiter Screening', 'interview_date' => '2026-03-16 10:00:00', 'mode' => 'Video', 'result' => 'Passed', 'notes' => 'Discussed background, salary expectations, and notice period.'],
                    ['stage_name' => 'Technical Interview', 'interview_date' => '2026-04-04 14:00:00', 'mode' => 'Video', 'result' => 'Pending', 'notes' => 'Prepare API design discussion and Laravel fundamentals.'],
                ],
                'reminders' => [
                    ['title' => 'Review backend interview notes', 'description' => 'Go over authentication, queues, and database indexing before the technical round.', 'remind_at' => '2026-04-03 19:00:00', 'is_completed' => false, 'completed_at' => null],
                ],
            ],
            [
                'company' => 'Atlas Systems',
                'job_title' => 'Associate Full Stack Developer',
                'date_applied' => Carbon::parse('2026-03-22'),
                'status' => 'Screening',
                'expected_salary' => 4500,
                'offered_salary' => null,
                'job_location' => 'Petaling Jaya',
                'notes' => 'Referral from university senior working in the product team.',
                'history' => [
                    [null, 'Applied', '2026-03-22 08:45:00', 'Applied with referral note and project links.'],
                    ['Applied', 'Screening', '2026-03-27 15:30:00', 'HR asked for graduation date and work authorization details.'],
                ],
                'interviews' => [],
                'reminders' => [
                    ['title' => 'Send screening follow-up', 'description' => 'Check in with HR if there is no update after one week.', 'remind_at' => '2026-04-03 09:00:00', 'is_completed' => false, 'completed_at' => null],
                ],
            ],
            [
                'company' => 'BlueOrbit Labs',
                'job_title' => 'QA Analyst',
                'date_applied' => Carbon::parse('2026-02-18'),
                'status' => 'Rejected',
                'expected_salary' => 3500,
                'offered_salary' => null,
                'job_location' => 'Remote',
                'notes' => 'Useful practice interview even though the role was not the best fit.',
                'history' => [
                    [null, 'Applied', '2026-02-18 13:00:00', 'Applied through LinkedIn Easy Apply.'],
                    ['Applied', 'Interview', '2026-02-24 10:00:00', 'Shortlisted for QA process and test-case discussion.'],
                    ['Interview', 'Rejected', '2026-03-01 17:10:00', 'Company moved forward with a candidate who had more automation experience.'],
                ],
                'interviews' => [
                    ['stage_name' => 'QA Interview', 'interview_date' => '2026-02-26 11:30:00', 'mode' => 'Video', 'result' => 'Completed', 'notes' => 'Answered test planning questions and bug triage scenarios.'],
                ],
                'reminders' => [],
            ],
            [
                'company' => 'Horizon Works',
                'job_title' => 'Software Engineer Intern',
                'date_applied' => Carbon::parse('2026-01-28'),
                'status' => 'Offer',
                'expected_salary' => 1800,
                'offered_salary' => 2200,
                'job_location' => 'Cyberjaya',
                'notes' => 'Offer received with mentoring plan and hybrid schedule.',
                'history' => [
                    [null, 'Applied', '2026-01-28 09:10:00', 'Applied with internship cover letter and academic transcript.'],
                    ['Applied', 'Interview', '2026-02-03 14:15:00', 'Invited to engineering manager interview.'],
                    ['Interview', 'Offer', '2026-02-09 18:00:00', 'Received internship offer and onboarding timeline.'],
                ],
                'interviews' => [
                    ['stage_name' => 'Hiring Manager Interview', 'interview_date' => '2026-02-05 15:00:00', 'mode' => 'On-site', 'result' => 'Passed', 'notes' => 'Discussed internship goals, project ownership, and team culture.'],
                ],
                'reminders' => [
                    ['title' => 'Decide on internship offer', 'description' => 'Review stipend, work mode, and start date before responding.', 'remind_at' => '2026-02-12 12:00:00', 'is_completed' => true, 'completed_at' => '2026-02-11 09:30:00'],
                ],
            ],
            [
                'company' => 'Northwind Data',
                'job_title' => 'Support Engineer',
                'date_applied' => Carbon::parse('2026-03-30'),
                'status' => 'Applied',
                'expected_salary' => 3900,
                'offered_salary' => null,
                'job_location' => 'Shah Alam',
                'notes' => 'Strong fallback option with good training plan.',
                'history' => [
                    [null, 'Applied', '2026-03-30 20:10:00', 'Submitted application after networking event.'],
                ],
                'interviews' => [],
                'reminders' => [
                    ['title' => 'Follow up on support engineer role', 'description' => 'Ask whether the team has started screening applications.', 'remind_at' => '2026-04-01 09:30:00', 'is_completed' => false, 'completed_at' => null],
                ],
            ],
            [
                'company' => 'Pixel Forge',
                'job_title' => 'Product Analyst',
                'date_applied' => Carbon::parse('2026-04-01'),
                'status' => 'Wishlist',
                'expected_salary' => 4300,
                'offered_salary' => null,
                'job_location' => 'Remote',
                'notes' => 'Still researching the company before submitting the application.',
                'history' => [
                    [null, 'Wishlist', '2026-04-01 18:45:00', 'Saved the role while preparing case-study examples.'],
                ],
                'interviews' => [],
                'reminders' => [
                    ['title' => 'Finish Pixel Forge application', 'description' => 'Customize resume and prepare portfolio story for analytics projects.', 'remind_at' => '2026-04-05 10:00:00', 'is_completed' => false, 'completed_at' => null],
                ],
            ],
        ];

        foreach ($applications as $data) {
            $application = Application::query()->create([
                'user_id' => $demoUser->id,
                'company_id' => $companies[$data['company']]->id,
                'job_title' => $data['job_title'],
                'date_applied' => $data['date_applied']->format('Y-m-d'),
                'status' => $data['status'],
                'expected_salary' => $data['expected_salary'],
                'offered_salary' => $data['offered_salary'],
                'job_location' => $data['job_location'],
                'notes' => $data['notes'],
            ]);

            foreach ($data['history'] as [$oldStatus, $newStatus, $changedAt, $remarks]) {
                $application->statusHistory()->create([
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'changed_at' => Carbon::parse($changedAt),
                    'remarks' => $remarks,
                ]);
            }

            foreach ($data['interviews'] as $interview) {
                $application->interviews()->create($interview);
            }

            foreach ($data['reminders'] as $reminder) {
                $application->reminders()->create($reminder);
            }
        }
    }
}
