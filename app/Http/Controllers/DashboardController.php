<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Interview;
use App\Models\Reminder;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $userId = (int) auth()->id();

        $applications = Application::query()
            ->ownedBy($userId)
            ->with('company')
            ->latest('date_applied')
            ->get();

        $upcomingInterviewsQuery = Interview::query()
            ->whereNotNull('interview_date')
            ->where('interview_date', '>=', now())
            ->whereHas('application', fn ($query) => $query->ownedBy($userId))
            ->with('application.company');

        $overdueRemindersQuery = Reminder::query()
            ->where('is_completed', false)
            ->where('remind_at', '<', now())
            ->whereHas('application', fn ($query) => $query->ownedBy($userId))
            ->with('application.company');

        $upcomingInterviews = (clone $upcomingInterviewsQuery)
            ->orderBy('interview_date')
            ->limit(5)
            ->get();

        $overdueReminders = (clone $overdueRemindersQuery)
            ->orderBy('remind_at')
            ->limit(5)
            ->get();

        $statusBreakdown = collect(Application::statuses())
            ->map(function (string $status) use ($applications) {
                return [
                    'label' => $status,
                    'count' => $applications->where('status', $status)->count(),
                    'color' => Application::statusHexColor($status),
                ];
            });

        $statusChartData = $statusBreakdown
            ->filter(fn (array $status) => $status['count'] > 0)
            ->values();

        $statusDistributionStyle = $this->buildStatusDistributionStyle($statusChartData);

        $monthlyActivity = collect(range(5, 0))
            ->map(function (int $monthsAgo) use ($applications) {
                $month = now()->copy()->startOfMonth()->subMonths($monthsAgo);
                $count = $applications->filter(
                    fn (Application $application) => $application->date_applied->format('Y-m') === $month->format('Y-m')
                )->count();

                return [
                    'label' => $month->format('M'),
                    'full_label' => $month->format('M Y'),
                    'count' => $count,
                ];
            });

        $expectedSalaries = $applications
            ->pluck('expected_salary')
            ->filter(fn ($salary) => $salary !== null)
            ->map(fn ($salary) => (float) $salary);

        $offeredSalaries = $applications
            ->pluck('offered_salary')
            ->filter(fn ($salary) => $salary !== null)
            ->map(fn ($salary) => (float) $salary);

        return view('dashboard-overview', [
            'stats' => [
                'total' => $applications->count(),
                'pending' => $applications->whereIn('status', ['Wishlist', 'Applied', 'Screening'])->count(),
                'upcoming_interviews' => (clone $upcomingInterviewsQuery)->count(),
                'overdue_reminders' => (clone $overdueRemindersQuery)->count(),
                'offers' => $applications->where('status', 'Offer')->count(),
            ],
            'recentApplications' => $applications->take(5),
            'upcomingInterviews' => $upcomingInterviews,
            'overdueReminders' => $overdueReminders,
            'statusBreakdown' => $statusBreakdown,
            'statusChartData' => $statusChartData,
            'statusDistributionStyle' => $statusDistributionStyle,
            'monthlyActivity' => $monthlyActivity,
            'maxMonthlyActivityCount' => max(1, (int) $monthlyActivity->max('count')),
            'salaryInsights' => [
                'expected_count' => $expectedSalaries->count(),
                'average_expected' => $expectedSalaries->avg(),
                'offer_count' => $offeredSalaries->count(),
                'average_offered' => $offeredSalaries->avg(),
                'highest_offer' => $offeredSalaries->max(),
            ],
        ]);
    }

    private function buildStatusDistributionStyle(Collection $statusChartData): ?string
    {
        if ($statusChartData->isEmpty()) {
            return null;
        }

        $total = (int) $statusChartData->sum('count');
        $currentAngle = 0;

        $segments = $statusChartData->map(function (array $status) use ($total, &$currentAngle) {
            $startAngle = $currentAngle;
            $currentAngle += ($status['count'] / $total) * 360;

            return sprintf(
                '%s %.2fdeg %.2fdeg',
                $status['color'],
                $startAngle,
                $currentAngle
            );
        })->implode(', ');

        return "background: conic-gradient({$segments});";
    }
}
