<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use LaravelEnso\Companies\Models\Company;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateTreeRequest;
use App\Jobs\Tenant\CreateDB;
use App\Jobs\Tenant\Migration;

class Store extends Controller
{
    public function __invoke(ValidateTreeRequest $request, Tree $tree)
    {
        $data = $request->validated();
        $user = auth()->user();
        $company_count = Company::count();
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

        return [
            'message' => __('The tree was successfully created'),
            'redirect' => 'trees.edit',
            'param' => ['tree' => $tree->id],
        ];
    }
}
