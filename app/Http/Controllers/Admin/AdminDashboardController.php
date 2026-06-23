<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $pendingRequests = LeaveRequest::query()
            ->with(['user', 'department'])
            ->where('status', 'Pending')
            ->orderBy('start_date', 'asc')
            ->paginate(8, ['*'], 'pending_page');

        $recentAudits = LeaveRequest::query()
            ->with(['user', 'department', 'reviewer'])
            ->whereIn('status', ['Approved', 'Rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'pendingRequests' => $pendingRequests,
            'recentAudits' => $recentAudits,
            'pendingCount' => LeaveRequest::query()->where('status', 'Pending')->get()->count(),
            'approvedCount' => LeaveRequest::query()->where('status', 'Approved')->get()->count(),
            'rejectedCount' => LeaveRequest::query()->where('status', 'Rejected')->get()->count(),
        ]);
    }
}
