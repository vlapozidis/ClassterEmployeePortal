<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Academic Operations', 'description' => 'Curriculum and teaching operations.'],
            ['name' => 'Student Services', 'description' => 'Student lifecycle and support services.'],
            ['name' => 'Information Technology', 'description' => 'Systems, infrastructure, and security.'],
            ['name' => 'Human Resources', 'description' => 'People operations and recruitment.'],
            ['name' => 'Finance', 'description' => 'Accounting, planning, and reporting.'],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['name' => $department['name']],
                ['description' => $department['description']]
            );
        }
    }
}
