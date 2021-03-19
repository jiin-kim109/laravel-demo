<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::factory()->create([
            'name' => 'Admin'
        ]);

        $editor = Role::factory()->create([
            'name' => 'Editor'
        ]);

        $viewer = Role::factory()->create([
            'name' => 'Viewer'
        ]);

        $permissions = Permission::all();
        
        /*
        foreach($permissions as $permission) {
            DB::table('role_permissions')->insert([
                'permission_id' => $permission->id,
                'role_id' => $admin->id
            ]);
        }
        */

        $admin->permissions()->attach($permissions->pluck('id'));

        $editor->permissions()->attach($permissions->pluck('id'));

        $editor->permissions()->detach(2);

        $viewer->permissions()->attach([1,3]);
    }
}
