<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sitePermission = Permission::create(['name' => 'Site']);

        // manage site user
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-manage-user']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-manage-permission']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-manage-setting']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-manage-organization']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-view-log']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-view-audit-trail']);
        Permission::create(['parent_id' => $sitePermission->id, 'name' => 'site-developer']);
    }
}
