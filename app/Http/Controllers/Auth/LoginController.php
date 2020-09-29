<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;
use App\Models\User;
use App\Traits\ConnectionTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Events\Login;
use LaravelEnso\Multitenancy\Enums\Connections;
use LaravelEnso\Multitenancy\Services\Tenant;

class LoginController extends Controller
{
    use AuthenticatesUsers, ConnectionTrait;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->maxAttempts = config('enso.auth.maxLoginAttempts');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
    }

    protected function attemptLogin(Request $request)
    {
        $user = $this->loggableUser($request);

        if (!$user) {
            return false;
        }

        Auth::login($user, $request->input('remember'));

        Login::dispatch($user, $request->ip(), $request->header('User-Agent'));

        return true;
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'auth' => Auth::check(),
            'csrfToken' => csrf_token(),
        ]);
    }

    private function loggableUser(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();
        $company = $user->company();
        $tanent = false;
        if ($company) {
            $tanent = true;
        }
        // set company id as default
        $main_company = $user->person->company();
        if ($main_company !== null && !$user->isAdmin()) {
            $c_id = $main_company->id;
            $db = $c_id;
            $this->setConnection(Connections::Tenant, $db, $user->id);
            error_log('login log: ****************************************'.$db);

            if ($main_company == null && !$user->isAdmin())
            {

                $company = Company::create([
                    'name' => $user->person->name . ($company_count + 1),
                    'email' => $user->email,
                    // 'is_active' => 1,
                    'is_tenant' => 1,
                    'status' => 1,
                ]);
                $user->person->companies()->attach($company->id, ['person_id' => $user->person->id, 'is_main' => 0, 'is_mandatary' => 1, 'company_id' => $company->id]);
                $tree->name = $data['name'];
                $tree->description = $data['description'];
                $tree->user_id = $user->id;
                $tree->company_id = $company->id;
                $tree->save();

                CreateDB::dispatch($company, $user->id);
                Migration::dispatch($company->id, $user->id, $user->person->name, $user->email);

                $this->setConnection(Connections::Tenant, $company->id, $user->id);

            }
        }else {
            error_log('admin login log: **************************************** enso');

            if ($user->isAdmin()) {
                $this->setConnection('mysql', 'genealogia', $user->id);
            }
        }
        error_log('admin login log: **************************************** enso');

        if (!optional($user)->currentPasswordIs($request->input('password'))) {
            return;
        }

        if ($user->passwordExpired()) {
            throw ValidationException::withMessages([
                'email' => 'Password expired. Please set a new one.',
            ]);
        }

        if ($user->isInactive()) {
            throw ValidationException::withMessages([
                'email' => 'Account disabled. Please contact the administrator. support@genealogia.co.uk',
            ]);
        }

       /**
        *
        if (!$user->onGenericTrial() && !$user->isAdmin() && $user->role_id == 2) {
            $user->role_id = 3; //expired role
            $user->save();
        }
        */

       if ($user->role_id == 3) {
           $user->role_id = 2; // trial role
           $user->save();
       }
        return $user;
    }
}
