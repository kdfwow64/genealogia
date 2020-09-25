<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use LaravelEnso\Companies\Models\Company;
use Illuminate\Routing\Controller;
use App\Jobs\Tenant\DropDB;

class Destroy extends Controller
{
    public function __invoke(Tree $tree)
    {
        $company = Company::find($tree->company_id);
        DropDB::dispatch($company, $tree->user_id);
        $tree->delete();
      //  $company->delete();

        return [
            'message' => __('The tree was successfully deleted'),
            'redirect' => 'trees.index',
        ];
    }
}
