<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateModuleOwnerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('SuperAdmin');

        ## create permission for module "module"
        $group = 'module';
        $group_id = Permission::create(['name' => $group]);

        $permission = Permission::create(['parent_id' => $group_id->id, 'name' => $group . '-view']);
        $permission->assignRole($role);

        $permission = Permission::create(['parent_id' => $group_id->id, 'name' => $group . '-list']);
        $permission->assignRole($role);

        $permission = Permission::create(['parent_id' => $group_id->id, 'name' => $group . '-create']);
        $permission->assignRole($role);

        $permission = Permission::create(['parent_id' => $group_id->id, 'name' => $group . '-edit']);
        $permission->assignRole($role);

        $permission = Permission::create(['parent_id' => $group_id->id, 'name' => $group . '-delete']);
        $permission->assignRole($role);
    }
}
