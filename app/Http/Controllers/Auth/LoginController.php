<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ConnectionTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
        if ($main_company !== null && !($user->isAdmin())) {
            $c_id = $main_company->id;
            $db = $c_id;
            $this->setConnection(Connections::Tenant, $db, $user->id);
            error_log('login log: ****************************************'.$db);
        }else {
            error_log('admin login log: **************************************** enso');

            $this->setConnection('mysql', 'enso', $user->id);
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
                'email' => 'Account disabled. Please contact the administrator. wwwwwwwwwwwwwwwwww',
            ]);
        }

        if (!$user->onGenericTrial()) {
            $user->role_id = 3; //expired role
            $user->save();
        }

        return $user;
    }
}
