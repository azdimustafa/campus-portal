<?php
use Modules\Site\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Modules\Site\Entities\Module;
use Modules\Site\Entities\UserType;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create user types
        UserType::create(['id' => 1, 'code' => 'staff', 'name' => 'Staff', 'name_my' => 'Pekerja', 'domain' => 'um.edu.my']);
        UserType::create(['id' => 2, 'code' => 'student', 'name' => 'Student', 'name_my' => 'Pelajar', 'domain' => 'siswa.um.edu.my']);
        UserType::create(['id' => 3, 'code' => 'public', 'name' => 'Public', 'name_my' => 'Umum']);

        // create module data
        Module::create(['id' => 1, 'code' => 'SITE', 'name' => 'Site', 'description' => 'Site system configuration']);

        // create role 
        $role = Role::create(['id' => 1, 'module_id' => 1,  'name' => 'SuperAdmin', 'description' => 'For Developers', 'level' => 0]);
                Role::create(['id' => 999, 'module_id' => 1, 'name' => 'NormalUser', 'description' => 'Public user', 'level' => 999]);
        
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        ## create user superadmin
        $user = User::create([
            'user_type_id' => UserType::STAFF,
            'name' => 'MOHAMAD AZDI BIN MOHD MUSTAFA',
            'email' => 'azdi.uum@gmail.com',
            'password' => bcrypt('123456789'),
        ]);    
        $user->profile()->updateOrCreate(['user_id' => $user->id], [
            'salary_no' => '00010996',
        ]);
        $user->assignRole(['SuperAdmin', 'NormalUser']);

    }
}
