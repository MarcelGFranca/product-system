<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Create Permissions
		Permission::create(['name' => 'products permission']);
		Permission::create(['name' => 'categories permission']);
		Permission::create(['name' => 'brands permission']);

		Permission::create(['name' => 'create user']);
		Permission::create(['name' => 'view user']);
		Permission::create(['name' => 'update user']);
		Permission::create(['name' => 'delete user']);

		// Create Roles
		$adminRole = Role::create(['name' => 'admin']);
		$commonRole = Role::create(['name' => 'common']);


		// Let's give few permissions to admin role.
		$adminRole->givePermissionTo(['create user', 'view user', 'update user', 'delete user']);
		$commonRole->givePermissionTo(['products permission', 'categories permission', 'brands permission']);

		// Let's Create User and assign Role to it.

		$adminUser = User::firstOrCreate([
			'email' => 'admin@gmail.com',
		], [
			'name' => 'Admin',
			'email' => 'admin@gmail.com',
			'password' => Hash::make('12345678'),
		]);

		$adminUser->assignRole($adminRole);

		$commonUser = User::firstOrCreate([
			'email' => 'common@gmail.com'
		], [
			'name' => 'Common',
			'email' => 'common@gmail.com',
			'password' => Hash::make('12345678'),
		]);

		$commonUser->assignRole($commonRole);
	}
}
