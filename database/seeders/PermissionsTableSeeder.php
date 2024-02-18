<?php

namespace Database\Seeders;

use App\Models\Permission\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allPermissions = [
            // Administration
            'administration' => [
                [
                    'slug' => 'manage-administration-settings',
                    'title' => 'Manage Administration Settings'
                ],
                [
                    'slug' => 'manage-payroll-settings',
                    'title' => 'Manage Payroll Settings'
                ],
                [
                    'slug' => 'manage-tax-settings',
                    'title' => 'Manage Tax Settings'
                ],
                [
                    'slug' => 'manage-role-permission-settings',
                    'title' => 'Manage Role Permission Settings'
                ],
            ],

            // HR
            'hr' => [
                [
                    'slug' => 'view-departments',
                    'title' => 'view Departments'
                ],
                [
                    'slug' => 'manage-departments',
                    'title' => 'Manage Departments'
                ],
                [
                    'slug' => 'view-designations',
                    'title' => 'View Designations'
                ],
                [
                    'slug' => 'manage-designations',
                    'title' => 'Manage Designations'
                ],
                [
                    'slug' => 'view-employees',
                    'title' => 'View Employees'
                ],
                [
                    'slug' => 'manage-employees',
                    'title' => 'Manage Employees'
                ],
                [
                    'slug' => 'view-employee-termination',
                    'title' => 'View Employee Termination'
                ],
                [
                    'slug' => 'manage-employee-termination',
                    'title' => 'Manage Employee Termination'
                ],
                [
                    'slug' => 'view-employee-resignation',
                    'title' => 'View Employee Resignation'
                ],
                [
                    'slug' => 'manage-employee-resignation',
                    'title' => 'Manage Employee Resignation'
                ],
                [
                    'slug' => 'view-employee-leave',
                    'title' => 'View Employee Leave'
                ],
                [
                    'slug' => 'manage-employee-leave',
                    'title' => 'Manage Employee Leave'
                ],
                [
                    'slug' => 'view-employee-attendance',
                    'title' => 'View Employee Attendance'
                ],
                [
                    'slug' => 'manage-employee-attendance',
                    'title' => 'Manage Employee Attendance'
                ],
                [
                    'slug' => 'view-contractors',
                    'title' => 'View Contractors'
                ],
                [
                    'slug' => 'manage-contractors',
                    'title' => 'Manage Contractors'
                ],
                [
                    'slug' => 'view-salary-set',
                    'title' => 'View Salary Set'
                ],
                [
                    'slug' => 'manage-salary-set',
                    'title' => 'Manage Salary Set'
                ],

            ],

            // Payroll
            'payroll' => [
                [
                    'slug' => 'generate-salary',
                    'title' => 'Generate Salary'
                ],
                [
                    'slug' => 'view-salary',
                    'title' => 'Vew Salary'
                ],
                [
                    'slug' => 'manage-salary',
                    'title' => 'Manage Salary'
                ],
            ],

            //Inventory
            'inventory' => [
                [
                    'slug' => 'view-product-material-category',
                    'title' => 'View Product Material Category'
                ],
                [
                    'slug' => 'manage-product-material-category',
                    'title' => 'Manage Product Material Category'
                ],
                [
                    'slug' => 'view-product-material',
                    'title' => 'View Product Material'
                ],
                [
                    'slug' => 'manage-product-material',
                    'title' => 'Manage Product Material'
                ],
                [
                    'slug' => 'view-asset-product-category',
                    'title' => 'View Asset Product Category'
                ],
                [
                    'slug' => 'manage-asset-product-category',
                    'title' => 'Manage Asset Product Category'
                ],
                [
                    'slug' => 'view-asset-product',
                    'title' => 'View Asset Product'
                ],
                [
                    'slug' => 'manage-asset-product',
                    'title' => 'Manage Asset Product'
                ],
                [
                    'slug' => 'view-warehouse',
                    'title' => 'View Warehouse'
                ],
                [
                    'slug' => 'manage-warehouse',
                    'title' => 'Manage Warehouse'
                ],
            ],

            //Accounting
            'accounting' => [
                [
                    'slug' => 'view-chart-of-accounts',
                    'title' => 'View Chart of Accounts'
                ],
                [
                    'slug' => 'manage-chart-of-accounts',
                    'title' => 'Manage Chart of Accounts'
                ],
            ],

            //Procurement
            'procurement' => [
                [
                    'slug' => 'view-suppliers',
                    'title' => 'View Suppliers'
                ],
                [
                    'slug' => 'manage-suppliers',
                    'title' => 'Manage Suppliers'
                ],
                [
                    'slug' => 'view-product-material-purchase-orders',
                    'title' => 'View Product Material Purchase Orders'
                ],
                [
                    'slug' => 'manage-product-material-purchase-orders',
                    'title' => 'Manage Product Material Purchase Orders'
                ],
                [
                    'slug' => 'product-material-purchase-order-payment',
                    'title' => 'Product Material Purchase Order Payment'
                ],
                [
                    'slug' => 'view-asset-product-purchase-request',
                    'title' => 'View Asset Product Purchase Request'
                ],
                [
                    'slug' => 'create-asset-product-purchase-request',
                    'title' => 'Create Asset Product Purchase Request'
                ],
                [
                    'slug' => 'manage-asset-product-purchase-request',
                    'title' => 'Manage Asset Product Purchase Request'
                ],
                [
                    'slug' => 'view-asset-product-purchase-orders',
                    'title' => 'View Asset Product Purchase Orders'
                ],
                [
                    'slug' => 'manage-asset-product-purchase-orders',
                    'title' => 'Manage Asset Product Purchase Orders'
                ],
                [
                    'slug' => 'asset-product-purchase-order-payment',
                    'title' => 'Asset Product Purchase Order Payment'
                ],
            ]
        ];

        foreach ($allPermissions as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'group' => $group,
                    'slug' => $permission['slug'],
                    'title' => $permission['title'],
                    'status' => 1,
                    'created_at' => now(),
                    'created_by' => 1,
                    'updated_at' => now(),
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
