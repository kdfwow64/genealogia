<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;
use App\Models\User;
use App\Traits\ConnectionTrait;
use App\Tree;
use App\Person;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Events\Login;
use LaravelEnso\Core\Traits\Logout;
use LaravelEnso\Multitenancy\Enums\Connections;
use LaravelEnso\Multitenancy\Services\Tenant;

class LoginController extends Controller
{
    use AuthenticatesUsers, ConnectionTrait, Logout {
        Logout::logout insteadof AuthenticatesUsers;
    }
    protected $redirectTo = '/';

    private ?User $user;

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
        $this->user = $this->loggableUser($request);

        if (! $this->user) {
            return false;
        }

        if ($request->attributes->get('sanctum')) {
            Auth::guard('web')->login($this->user, $request->input('remember'));
        }

        Login::dispatch($this->user, $request->ip(), $request->header('User-Agent'));

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($request->attributes->get('sanctum')) {
            $request->session()->regenerate();

            return [
                'auth' => Auth::check(),
                'csrfToken' => csrf_token(),
            ];
        }

        $token = $this->user->createToken($request->get('device_name'));

        return response()->json(['token' => $token->plainTextToken])
            ->cookie('webview', true)
            ->cookie('Authorization', $token->plainTextToken);
    }

    protected function validateLogin(Request $request)
    {
        $attributes = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        if (! $request->attributes->get('sanctum')) {
            $attributes['device_name'] = 'required|string';
        }

        $request->validate($attributes);
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
            error_log('login log: ****************************************' . $db);
        }

            if ($main_company == null && !$user->isAdmin())
            {
                $company_count = Company::count();

                $company = Company::create([
                    'name' => $user->email . ($company_count + 1),
                    'email' => $user->email,
                    // 'is_active' => 1,
                    'is_tenant' => 1,
                    'status' => 1,
                ]);
                $user->person->companies()->attach($company->id, ['person_id' => $user->person->id, 'is_main' => 1, 'is_mandatary' => 1, 'company_id' => $company->id]);
                Tree::create([
                    'name' => 'Default Tree',
                    'description' => 'Automatically created tree as only tree remaining was deleted.',
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                ]);

                $company_id = $company->id;
                $user_id = $user->id;
                $person_name = $user->person->name;
                $user_email = $user->email;

                $db = $company_id;
                $this->setConnection(Connections::Tenant, $db, $user_id);
                $this->getConnection();

                CreateDB::dispatch($company, $user_id);
                Migration::dispatch($company_id, $user_id, $person_name, $user_email);


        }else {
            error_log('admin login log: **************************************** enso');

            if ($user->isAdmin()) {
                $this->setConnection('mysql', 'genealogia', $user->id);
            }
        }
        // error_log('admin login log: **************************************** enso');

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
