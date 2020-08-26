<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    private const Roles = [
        ['menu_id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
        ['menu_id' => 1, 'name' => 'trial', 'display_name' => 'Trial', 'description' => 'Trial role.'],
        ['menu_id' => 1, 'name' => 'expired', 'display_name' => 'Expired', 'description' => 'Expired role.'],
        ['menu_id' => 1, 'name' => 'otm', 'display_name' => 'One tree monthly', 'description' => 'OTM role.'],
        ['menu_id' => 1, 'name' => 'oty', 'display_name' => 'One tree yearly', 'description' => 'OTY role.'],
        ['menu_id' => 1, 'name' => 'ttm', 'display_name' => 'Ten tree monthly', 'description' => 'TTM role.'],
        ['menu_id' => 1, 'name' => 'tty', 'display_name' => 'Ten tree yearly', 'description' => 'TTY role.'],
        ['menu_id' => 1, 'name' => 'utm', 'display_name' => 'Unlimited tree monthly', 'description' => 'UTM role.'],
        ['menu_id' => 1, 'name' => 'uty', 'display_name' => 'Unlimited tree yearly', 'description' => 'UTY role.'],
    ];

    public function run()
    {
        $roles = (new Collection(self::Roles))
            ->map(fn ($role) => factory(Role::class)->create($role));

        $admin = $roles->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $supervisor = $roles->skip(1)->first();

        $supervisor->permissions()->sync(Permission::implicit()->pluck('id'));
        $user = $roles->last();

        $user->permissions()->sync(Permission::implicit()->pluck('id'));
    }
}
