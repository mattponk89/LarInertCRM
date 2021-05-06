<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Permission::create(['name' => 'import export']);
      $role1 = Role::create(['name' => 'admin']);
      $role1->givePermissionTo('import export');
      $user = \App\Models\User::factory()->create([
        'name' => 'Administrator',
        'email' => 'test@example.com',
        'password' => Hash::make('test1234'),
      ]);
      $user->assignRole($role1);
    }
}
