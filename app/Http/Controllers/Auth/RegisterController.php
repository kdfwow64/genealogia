<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Models\UserGroup;
use LaravelEnso\Roles\Models\Role;
use App\Models\User;
use App\Person;
use App\Tree;
use App\Providers\RouteServiceProvider;
use App\Traits\ActivationTrait;
use Illuminate\Support\Facades\DB;
// use LaravelEnso\Multitenancy\Jobs\CreateDatabase;
// use LaravelEnso\Multitenancy\Jobs\Migrate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ConnectionTrait;
use LaravelEnso\Multitenancy\Enums\Connections;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ActivationTrait;
    use ConnectionTrait;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        try {
            // DB::beginTransaction();
            // create person
            $person = new Person();
            $person->givn = $data['first_name'];
            $person->surn = $data['last_name'];
            $person->name = $data['first_name'] . ' ' . $data['last_name'];
            $person->email = $data['email'];
            $person->save();

            // get user_group_id
            $user_group = UserGroup::where('name', 'Administrators')->first();
            if ($user_group == null) {
                // create user_group
                $user_group = UserGroup::create(['name'=>'Administrators', 'description'=>'Administrator users group']);
            }

            // get role_id
            $role = Role::where('name', 'free')->first();
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'person_id' => $person->id,
                'group_id' => $user_group->id,
                'role_id' => $role->id,
                'is_active' => 1,
                'trial_ends_at' => now()->addDays(7)
            ]);


            // send verification email;

            $this->initiateEmailActivation($user);

            $company = Company::create([
                'name' => $data['email'] . '-' .  $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                // 'is_active' => 1,
                'is_tenant' => 1,
                'status' => 1,
            ]);

//          $company->attachPerson($person->id, 'Owner');
            // DB::commit();

            $person->companies()->attach($company->id, ['person_id' => $person->id, 'is_main' => 1, 'is_mandatary' => 1, 'company_id' => $company->id]);

            // set session
            $main_company = $company;
            if($main_company !== null && !($user->isAdmin())) {
                $c_id = $main_company->id;
                $db = $c_id;
                $this->setConnection(Connections::Tenant, $db, $user->id);
            }
            // Dispatch Tenancy Jobs

            $name = $data['email'] . ' - ' . $data['first_name'] . ' ' . $data['last_name'];

            CreateDB::dispatch($company, $user->id);
            Migration::dispatch($company->id, $user->id, $name, $data['email']);

            $tree = new Tree();
            $tree->company_id = $company->id;
            $tree->user_id = $user->id;
            $tree->name = 'default';
            $tree->description = 'Default Tree';
            $tree->save();

            return $user;
        } catch (\Exception $e) {
            // DB::rollBack();
            throw $e;
        }
    }
}
