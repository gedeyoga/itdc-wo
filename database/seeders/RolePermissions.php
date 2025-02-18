<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();

        $roles = Role::all();
        $permissions = [ 
            ['name' => 'user.user-list', 'guard_name' => 'sanctum'],
            ['name' => 'user.user-create', 'guard_name' => 'sanctum'],
            ['name' => 'user.user-update', 'guard_name' => 'sanctum'],
            ['name' => 'user.user-delete', 'guard_name' => 'sanctum'],
            ['name' => 'user.user-all', 'guard_name' => 'sanctum'],
            ['name' => 'role.role-list', 'guard_name' => 'sanctum'],
            ['name' => 'role.role-create', 'guard_name' => 'sanctum'],
            ['name' => 'role.role-update', 'guard_name' => 'sanctum'],
            ['name' => 'role.role-delete', 'guard_name' => 'sanctum'],
            ['name' => 'task.task-list', 'guard_name' => 'sanctum'],
            ['name' => 'task.task-create', 'guard_name' => 'sanctum'],
            ['name' => 'task.task-update', 'guard_name' => 'sanctum'],
            ['name' => 'task.task-delete', 'guard_name' => 'sanctum'],
            ['name' => 'priority.priority-list', 'guard_name' => 'sanctum'],
            ['name' => 'priority.priority-create', 'guard_name' => 'sanctum'],
            ['name' => 'priority.priority-update', 'guard_name' => 'sanctum'],
            ['name' => 'priority.priority-delete', 'guard_name' => 'sanctum'],
            ['name' => 'task-category.task-category-list', 'guard_name' => 'sanctum'],
            ['name' => 'task-category.task-category-create', 'guard_name' => 'sanctum'],
            ['name' => 'task-category.task-category-update', 'guard_name' => 'sanctum'],
            ['name' => 'task-category.task-category-delete', 'guard_name' => 'sanctum'],
            ['name' => 'task-schedule.task-schedule-list', 'guard_name' => 'sanctum'],
            ['name' => 'task-schedule.task-schedule-create', 'guard_name' => 'sanctum'],
            ['name' => 'task-schedule.task-schedule-update', 'guard_name' => 'sanctum'],
            ['name' => 'task-schedule.task-schedule-delete', 'guard_name' => 'sanctum'],
            ['name' => 'dashboard.dashboard-user', 'guard_name' => 'sanctum'],
            ['name' => 'dashboard.dashboard-admin', 'guard_name' => 'sanctum'],
            ['name' => 'workorder.workorder-list', 'guard_name' => 'sanctum'],
            ['name' => 'workorder.workorder-create', 'guard_name' => 'sanctum'],
            ['name' => 'workorder.workorder-update', 'guard_name' => 'sanctum'],
            ['name' => 'workorder.workorder-delete', 'guard_name' => 'sanctum'],
            ['name' => 'report-monthly.report-monthly-list', 'guard_name' => 'sanctum'],
            ['name' => 'report-daily.report-daily-list', 'guard_name' => 'sanctum'],
            ['name' => 'location.location-list', 'guard_name' => 'sanctum'],
            ['name' => 'location.location-create', 'guard_name' => 'sanctum'],
            ['name' => 'location.location-update', 'guard_name' => 'sanctum'],
            ['name' => 'location.location-delete', 'guard_name' => 'sanctum'],
            ['name' => 'location-installation.location-installation-list', 'guard_name' => 'sanctum'],
            ['name' => 'location-installation.location-installation-create', 'guard_name' => 'sanctum'],
            ['name' => 'location-installation.location-installation-update', 'guard_name' => 'sanctum'],
            ['name' => 'location-installation.location-installation-delete', 'guard_name' => 'sanctum'],
            ['name' => 'tenant.tenant-list', 'guard_name' => 'sanctum'],
            ['name' => 'tenant.tenant-create', 'guard_name' => 'sanctum'],
            ['name' => 'tenant.tenant-update', 'guard_name' => 'sanctum'],
            ['name' => 'tenant.tenant-delete', 'guard_name' => 'sanctum'],
            ['name' => 'history.history-asset-list', 'guard_name' => 'sanctum'],
            ['name' => 'history.history-asset-detail', 'guard_name' => 'sanctum'],
            ['name' => 'pompa.pompa-list', 'guard_name' => 'sanctum'],
            ['name' => 'pompa.pompa-create', 'guard_name' => 'sanctum'],
            ['name' => 'pompa.pompa-update', 'guard_name' => 'sanctum'],
            ['name' => 'pompa.pompa-delete', 'guard_name' => 'sanctum'],
            ['name' => 'asset-master.asset-master-list', 'guard_name' => 'sanctum'],
            ['name' => 'asset-master.asset-master-create', 'guard_name' => 'sanctum'],
            ['name' => 'asset-master.asset-master-update', 'guard_name' => 'sanctum'],
            ['name' => 'asset-master.asset-master-delete', 'guard_name' => 'sanctum'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $data_permissions = Permission::all();

        foreach ($roles as $role) {
            foreach ($data_permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
