<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payload = [
            'company_name' => 'AjaxERP',
            'address' => '281 Purok 6 Santisimo Road Brgy Soledad San Pablo City',
            'email' => 'sales@sterk.ph',
            'phone' => '+639943648519',
        ];

        $company = Company::query()->first();

        if ($company) {
            $company->update(array_merge($payload, [
                'status' => 1,
                'deleted' => 0,
                'updated_at' => now(),
            ]));
            return;
        }

        Company::query()->create(array_merge($payload, [
            'status' => 1,
            'deleted' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'synced' => false,
        ]));
    }
}

