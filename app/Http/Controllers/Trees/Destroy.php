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
use ConnectionTrait;


    public function __invoke(Tree $tree)
    {

        $user = auth()->user();

        if ($user->id == $tree->user_id) {
            $original_company = Company::find($tree->company_id);
            // DropDB::dispatch($original_company, $tree->user_id);
            $original_company->delete();
            $tree->delete();


            if (Company::where('email', '=', $user->email)->count() == 0) {

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
