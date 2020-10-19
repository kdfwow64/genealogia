<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;

class CustomPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $link = [
        'administration.people.initTable',
        'administration.people.tableData',
        'administration.people.exportExcel',
        'administration.people.options',
        'administration.people.create',
        'administration.people.edit',
        'administration.people.index',
        'administration.people.store',
        'administration.people.update',
        'administration.people.destroy',
        'administration.users.initTable',
        'administration.users.tableData',
        'administration.users.exportExcel',
        'administration.users.options',
        'administration.users.create',
        'administration.users.edit',
        'administration.users.index',
        'administration.users.show',
        'administration.users.store',
        'administration.users.update',
        'administration.users.destroy',
        'administration.users.token',
        'administration.companies.initTable',
        'administration.companies.tableData',
        'administration.companies.exportExcel',
        'administration.companies.options',
        'administration.companies.create',
        'administration.companies.edit',
        'administration.companies.index',
        'administration.companies.store',
        'administration.companies.update',
        'administration.companies.destroy',
        'administration.companies.people.create',
        'administration.companies.people.edit',
        'administration.companies.people.index',
        'administration.companies.people.store',
        'administration.companies.people.update',
        'administration.companies.people.destroy',
        'trees.create',
        'trees.destroy',
        'trees.edit',
        'trees.exportExcel',
        'trees.index',
        'trees.initTable',
        'trees.options',
        'trees.show',
        'trees.store',
        'trees.tableData',
        'trees.update'
    ];
    public function run()
    {
        $roles = [
            ['menu_id' => 1, 'name' => 'free', 'display_name' => 'Free', 'description' => 'Free role.'],
            ['menu_id' => 1, 'name' => 'expired', 'display_name' => 'Expired', 'description' => 'Expired role.'],
            ['menu_id' => 1, 'name' => 'otm', 'display_name' => 'One tree monthly', 'description' => 'OTM role.'],
            ['menu_id' => 1, 'name' => 'oty', 'display_name' => 'One tree yearly', 'description' => 'OTY role.'],
            ['menu_id' => 1, 'name' => 'ttm', 'display_name' => 'Ten tree monthly', 'description' => 'TTM role.'],
            ['menu_id' => 1, 'name' => 'tty', 'display_name' => 'Ten tree yearly', 'description' => 'TTY role.'],
            ['menu_id' => 1, 'name' => 'utm', 'display_name' => 'Unlimited tree monthly', 'description' => 'UTM role.'],
            ['menu_id' => 1, 'name' => 'uty', 'display_name' => 'Unlimited tree yearly', 'description' => 'UTY role.'],
        ];

        foreach ($roles as $role)
        {
            Role::create($role);
        }

        /**
        $admin = $roles->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $supervisor = $roles->skip(1)->first();

        $supervisor->permissions()->sync(Permission::implicit()->pluck('id'));
        $user = $roles->last();

        $user->permissions()->sync(Permission::implicit()->pluck('id'));

        **/

        $trial = Role::where('name', 'free')->first();
        $role_id = $trial->id;
        foreach($this->link as $link){
            $permission = Permission::where('name', $link)->first();
            if($permission !== null ) {
                $permission->roles()->detach($role_id);
                $permission->roles()->attach($role_id);
            }
        }
        $expired = Role::where('name', 'expired')->first();
        $role_id = $expired->id;
        $expired_permissions = [
            'core.home.index',
            'core.avatars.update',
            'core.avatars.show',
            'core.avatars.store',
            'core.preferences.store',
            'core.preferences.reset',
            'dashboard.index',
            'payment.index',
            'subscription.index',
            'subscription.success',
            'subscription.cancel'
        ];
        foreach($expired_permissions as $permission){
            $permission = Permission::where('name', $permission)->first();
            if($permission !== null ) {
                $permission->roles()->detach($role_id);
                $permission->roles()->attach($role_id);
            }
        }
        $roles = Role::whereNotIn('name', ['free', 'expired'])->get();
        foreach($roles as $role) {

            $permissions = Permission::where([
                ['name','not like', '%system%'],
                ['name','not like', '%administration.userGroups%'],
                ['name','not like', '%administration.users%'],
                ['name','not like', '%administration.teams%'],
                ['name','not like', '%administration.companies%'],
            ])->get();

            foreach($permissions as $permission){
                if($permission !== null ) {
                    $permission->roles()->detach($role->id);
                    $permission->roles()->attach($role->id);
                }
            }
        }
    }
}
