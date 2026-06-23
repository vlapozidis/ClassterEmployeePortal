<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $dashboardCards = [
            [
                'label' => 'Employee Name',
                'value' => $request->user()->name,
                'note' => 'From authenticated session',
            ],
            [
                'label' => 'Department',
                'value' => 'Academic Operations',
                'note' => 'Dummy data for MVP',
            ],
            [
                'label' => 'Work Mode',
                'value' => 'Hybrid',
                'note' => 'Dummy data for MVP',
            ],
            [
                'label' => 'Leave Balance',
                'value' => '14 days',
                'note' => 'Dummy data for MVP',
            ],
            [
                'label' => 'Pending Requests',
                'value' => '2',
                'note' => 'Dummy data for MVP',
            ],
        ];

        return view('dashboard', [
            'dashboardCards' => $dashboardCards,
        ]);
    }
}
