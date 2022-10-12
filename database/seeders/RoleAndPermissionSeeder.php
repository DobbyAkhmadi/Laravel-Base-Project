<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions
        $userSA = User::where('identity_number', '01012001')->first();
        if (empty($userSA)) {
            $userSA = User::factory()->create([
                'identity_number' => '01012001',
                'name' => 'super administrator',
                'email' => 'super.admin@sample.co.id',
                'password' => 'password', // password
            ]);
        }
        $roleSA = Role::where('name', 'super-admin')->first();
        if (empty($roleSA)) {
            $roleSA = Role::create([
                'name' => 'super-admin',
                'guard_name' => 'api',
                'descriptions' => 'Super Administrator',
            ]);
        }
        $roleSA->givePermissionTo(permission::all());
        $userSA->assignRole($roleSA);
    }
}
