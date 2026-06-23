<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-white">Admin Dashboard</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-5">
        @if (session('status'))
            <div class="rounded-xl border border-green-600/40 bg-green-900/20 px-4 py-3 text-sm text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-[#1F1F1F] bg-[#111111] p-4">
                <p class="text-xs uppercase tracking-wide text-[#A1A1AA]">Pending Requests</p>
                <p class="mt-2 text-2xl font-semibold text-white">{{ $pendingCount }}</p>
            </div>
            <div class="rounded-xl border border-[#1F1F1F] bg-[#111111] p-4">
                <p class="text-xs uppercase tracking-wide text-[#A1A1AA]">Approved Requests</p>
                <p class="mt-2 text-2xl font-semibold text-white">{{ $approvedCount }}</p>
            </div>
            <div class="rounded-xl border border-[#1F1F1F] bg-[#111111] p-4">
                <p class="text-xs uppercase tracking-wide text-[#A1A1AA]">Rejected Requests</p>
                <p class="mt-2 text-2xl font-semibold text-white">{{ $rejectedCount }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-[#1F1F1F] bg-[#111111]">
            <div class="border-b border-[#1F1F1F] px-4 py-3">
                <h3 class="text-sm font-semibold text-white">Pending Leave Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#1F1F1F] text-sm">
                    <thead class="bg-[#0A0A0A]">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Employee</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Department</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Date Range</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Reason</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1F1F1F]">
                        @forelse ($pendingRequests as $request)
                            <tr>
                                <td class="px-4 py-3 text-white">{{ $request->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ $request->department?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ optional($request->start_date)->format('Y-m-d') }} to {{ optional($request->end_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ $request->reason }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex min-w-72 flex-col gap-2">
                                        <form method="POST" action="{{ route('admin.leave-requests.approve', $request) }}" class="flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="admin_comment" placeholder="Audit note (optional)" class="w-full rounded-lg border border-[#1F1F1F] bg-[#0A0A0A] px-3 py-1.5 text-xs text-white placeholder:text-[#71717A] focus:border-[#DC2626] focus:ring-[#DC2626]">
                                            <button type="submit" class="rounded-lg bg-green-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-600">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.leave-requests.reject', $request) }}" class="flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="admin_comment" placeholder="Audit note (optional)" class="w-full rounded-lg border border-[#1F1F1F] bg-[#0A0A0A] px-3 py-1.5 text-xs text-white placeholder:text-[#71717A] focus:border-[#DC2626] focus:ring-[#DC2626]">
                                            <button type="submit" class="rounded-lg bg-red-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-[#A1A1AA]">No pending leave requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[#1F1F1F] bg-[#0A0A0A] px-4 py-3 text-[#A1A1AA]">
                {{ $pendingRequests->links() }}
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-[#1F1F1F] bg-[#111111]">
            <div class="border-b border-[#1F1F1F] px-4 py-3">
                <h3 class="text-sm font-semibold text-white">Audit Trail (Recent Decisions)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#1F1F1F] text-sm">
                    <thead class="bg-[#0A0A0A]">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Employee</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Decision</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Reviewed By</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Reviewed At</th>
                            <th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Audit Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1F1F1F]">
                        @forelse ($recentAudits as $audit)
                            <tr>
                                <td class="px-4 py-3 text-white">{{ $audit->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ $audit->status }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ $audit->reviewer?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ optional($audit->reviewed_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-[#A1A1AA]">{{ $audit->admin_comment ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-[#A1A1AA]">No audit history yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
