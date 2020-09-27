<?php

namespace App\Http\Controllers\Trees;

use App\Traits\ConnectionTrait;
use LaravelEnso\Multitenancy\Enums\Connections;
use LaravelEnso\Multitenancy\Services\Tenant;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;
use App\Tree;
use LaravelEnso\Companies\Models\Company;
use Illuminate\Routing\Controller;
use App\Jobs\Tenant\DropDB;
use Illuminate\Support\Facades\Auth;

class Destroy extends Controller
{
    public function __construct()
    {
        // user must log in to use this controller
  //      $this->middleware('auth:api');
    }

    public function __invoke(Tree $tree)
    {
	use ConnectionTrait;

        $user = auth()->user();

        if ($user->id == $tree->user_id) {
            $original_company = Company::find($tree->company_id);
            DropDB::dispatch($original_company, $tree->user_id);
            $tree->delete();


            if (Company::where('email', '=', $user->email)->count() < 1) {

                $company_count = Company::count();
                $company = Company::create([
                    'name' => $user->person->name . ($company_count + 1),
                    'email' => $user->email,
                    // 'is_active' => 1,
                    'is_tenant' => 1,
                    'status' => 1,
                ]);
                $user->person->companies()->attach($company->id, ['person_id' => $user->person->id, 'is_main' => 0, 'is_mandatary' => 1, 'company_id' => $company->id]);
                $tree->name = 'Default tree';
                $tree->description = 'Default tree';
                $tree->user_id = $user->id;
                $tree->company_id = $company->id;
                $tree->save();

                CreateDB::dispatch($company, $user->id);
                Migration::dispatch($company->id, $user->id, $user->person->name, $user->email);

                $original_company->delete();

            $db = $company->id;
            $this->setConnection(Connections::Tenant, $db, Auth::user()->id);

            }
            return [
                'message' => __('The tree was successfully deleted'),
                'redirect' => 'trees.index',
            ];
        } else {
            return [
                'message' => __('The tree was not deleted'),
                'redirect' => 'trees.index',
            ];
        }
    }

}
