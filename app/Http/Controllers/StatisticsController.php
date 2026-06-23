<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request): View
    {
        $leavesPerMonth = $this->getLeavesPerMonth();
        $departmentLeaveUsage = $this->getDepartmentLeaveUsage();
        $employeeLeaveStatistics = $this->getEmployeeLeaveStatistics();

        return view('statistics.index', [
            'leavesPerMonth' => $leavesPerMonth,
            'departmentLeaveUsage' => $departmentLeaveUsage,
            'employeeLeaveStatistics' => $employeeLeaveStatistics,
        ]);
    }

    private function getLeavesPerMonth(): array
    {
        $months = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            $startDate = $date->startOfMonth()->toDateString();
            $endDate = $date->endOfMonth()->toDateString();

            $count = LeaveRequest::query()
                ->whereBetween('created_at', [$startDate, $endDate], 'and')
                ->get()
                ->count();

            $months[] = $monthLabel;
            $counts[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }

    private function getDepartmentLeaveUsage(): array
    {
        $departments = LeaveRequest::query()
            ->with('department')
            ->whereNotNull('department_id', 'and')
            ->get()
            ->groupBy('department_id')
            ->map(function ($leaves) {
                return [
                    'name' => $leaves->first()->department?->name ?? 'Unknown',
                    'count' => $leaves->count(),
                ];
            })
            ->values()
            ->sortByDesc('count')
            ->take(10);

        return [
            'labels' => $departments->pluck('name')->toArray(),
            'data' => $departments->pluck('count')->toArray(),
        ];
    }

    private function getEmployeeLeaveStatistics(): array
    {
        $employees = LeaveRequest::query()
            ->with('user')
            ->whereNotNull('user_id', 'and')
            ->get()
            ->groupBy('user_id')
            ->map(function ($leaves) {
                $approved = $leaves->where('status', 'Approved')->count();
                $pending = $leaves->where('status', 'Pending')->count();
                $rejected = $leaves->where('status', 'Rejected')->count();

                return [
                    'name' => $leaves->first()->user?->name ?? 'Unknown',
                    'approved' => $approved,
                    'pending' => $pending,
                    'rejected' => $rejected,
                    'total' => $leaves->count(),
                ];
            })
            ->values()
            ->sortByDesc('total')
            ->take(10);

        return [
            'labels' => $employees->pluck('name')->toArray(),
            'approved' => $employees->pluck('approved')->toArray(),
            'pending' => $employees->pluck('pending')->toArray(),
            'rejected' => $employees->pluck('rejected')->toArray(),
        ];
    }
}
