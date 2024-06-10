<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SpatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin', 'Bendahara', 'User'];
        $permissions = ['Dashboard', 'Manage User', 'Manage Kas', 'Riwayat Kas'];

        $list_role = [];
        $list_permission = [];

        foreach ($roles as $key => $value) {
            $list_role[$key] = Role::updateOrCreate(
                ['name' => $value],
                ['name' => $value]
            );
        }

        foreach ($permissions as $key => $value) {
            $list_permission[$key] = Permission::updateOrCreate(
                ['name' => $value],
                ['name' => $value]
            );
        }

        // Give permission Admin
        $list_role[0]->givePermissionTo($list_permission[0]);
        $list_role[0]->givePermissionTo($list_permission[1]);
        $list_role[0]->givePermissionTo($list_permission[2]);
        $list_role[0]->givePermissionTo($list_permission[3]);

        // Give permission Bendahara
        $list_role[1]->givePermissionTo($list_permission[0]);
        $list_role[1]->givePermissionTo($list_permission[2]);
        $list_role[1]->givePermissionTo($list_permission[3]);

        // Give permission User
        $list_role[2]->givePermissionTo($list_permission[0]);
        $list_role[2]->givePermissionTo($list_permission[3]);

        // $user = User::find(1);
        // $user->assignRole('Admin');
    }
}
