<x-app-layout>
	<x-slot name="header">
		<h2 class="text-2xl font-semibold leading-tight text-white">Employees Directory</h2>
	</x-slot>

	<div class="mx-auto max-w-7xl space-y-4">
		<div class="rounded-2xl border border-[#1F1F1F] bg-[#111111] p-5">
			<form method="GET" action="{{ route('employees.index') }}" class="grid gap-4 md:grid-cols-4">
				<div class="md:col-span-2">
					<label for="search" class="text-sm text-[#A1A1AA]">Search</label>
					<input
						id="search"
						name="search"
						type="text"
						value="{{ $filters['search'] }}"
						placeholder="Search by name or email"
						class="mt-1 block w-full rounded-lg border border-[#1F1F1F] bg-[#0A0A0A] text-white placeholder:text-[#71717A] focus:border-[#DC2626] focus:ring-[#DC2626]"
					>
				</div>

				<div>
					<label for="department_id" class="text-sm text-[#A1A1AA]">Department</label>
					<select
						id="department_id"
						name="department_id"
						class="mt-1 block w-full rounded-lg border border-[#1F1F1F] bg-[#0A0A0A] text-white focus:border-[#DC2626] focus:ring-[#DC2626]"
					>
						<option value="">All Departments</option>
						@foreach ($departments as $department)
							<option value="{{ $department->id }}" @selected((int) $filters['department_id'] === $department->id)>
								{{ $department->name }}
							</option>
						@endforeach
					</select>
				</div>

				<div>
					<label for="work_mode" class="text-sm text-[#A1A1AA]">Work Mode</label>
					<select
						id="work_mode"
						name="work_mode"
						class="mt-1 block w-full rounded-lg border border-[#1F1F1F] bg-[#0A0A0A] text-white focus:border-[#DC2626] focus:ring-[#DC2626]"
					>
						<option value="">All Work Modes</option>
						@foreach ($workModes as $mode)
							<option value="{{ $mode }}" @selected($filters['work_mode'] === $mode)>
								{{ $mode }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="md:col-span-4 flex flex-wrap items-center justify-end gap-2">
					<a href="{{ route('employees.index') }}" class="rounded-lg border border-[#1F1F1F] px-4 py-2 text-sm text-[#A1A1AA] transition hover:text-white">
						Reset
					</a>
					<button type="submit" class="rounded-lg bg-[#DC2626] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#B91C1C]">
						Apply Filters
					</button>
				</div>
			</form>
		</div>

		<div class="overflow-hidden rounded-2xl border border-[#1F1F1F] bg-[#111111]">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-[#1F1F1F] text-sm">
					<thead class="bg-[#0A0A0A]">
						<tr>
							<th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Employee</th>
							<th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Email</th>
							<th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Department</th>
							<th class="px-4 py-3 text-left font-medium text-[#A1A1AA]">Work Mode</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-[#1F1F1F]">
						@forelse ($employees as $employee)
							<tr>
								<td class="px-4 py-3 text-white">{{ $employee->name }}</td>
								<td class="px-4 py-3 text-[#A1A1AA]">{{ $employee->email }}</td>
								<td class="px-4 py-3 text-[#A1A1AA]">{{ $employee->department?->name ?? '-' }}</td>
								<td class="px-4 py-3 text-[#A1A1AA]">{{ $employee->work_mode ?? '-' }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="px-4 py-8 text-center text-[#A1A1AA]">No employees found for the selected filters.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<div class="border-t border-[#1F1F1F] bg-[#0A0A0A] px-4 py-3 text-[#A1A1AA]">
				{{ $employees->links() }}
			</div>
		</div>
	</div>
</x-app-layout>
