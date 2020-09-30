<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use App\Traits\ConnectionTrait;
use LaravelEnso\Multitenancy\Enums\Connections;
use LaravelEnso\Multitenancy\Services\Tenant;
use LaravelEnso\Companies\Models\Company;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateTreeRequest;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;
use Illuminate\Support\Facades\Auth;


class Store extends Controller
{
use ConnectionTrait;


    public function __invoke(ValidateTreeRequest $request, Tree $tree)
    {

        $data = $request->validated();
        $user = auth()->user();
        $company_count = Company::count();
        $company = Company::create([
            'name' => $user->email . ($company_count + 1),
            'email' => $user->email,
            // 'is_active' => 1,
            'is_tenant' => 1,
            'status' => 1,
        ]);

        if (Tree::where('user_id', '=', $user->id)->count() == 0 && Company::where('email', '=', $user->email)->count() == 0){

        $user->person->companies()->attach($company->id, ['person_id' => $user->person->id, 'is_main' => 1, 'is_mandatary' => 1, 'company_id' => $company->id]);
    }
        else {

        $user->person->companies()->attach($company->id, ['person_id' => $user->person->id, 'is_main' => 0, 'is_mandatary' => 1, 'company_id' => $company->id]);
    }

        $tree->name = $data['name'];
        $tree->description = $data['description'];
        $tree->user_id = $user->id;
        $tree->company_id = $company->id;
        $tree->save();

        $company_id = $company->id;
        $user_id = $user->id;
        $person_name = $user->person->name;
        $user_email = $user->email;

        $db = $company_id;
        $this->setConnection(Connections::Tenant, $db, $user_id);
        $this->getConnection();

        CreateDB::dispatch($company, $user_id);
        Migration::dispatch($company_id, $user_id, $person_name, $user_email);

        return [
            'message' => __('The tree was successfully created'),
            'redirect' => 'trees.edit',
            'param' => ['tree' => $tree->id],
        ];
    }
}

