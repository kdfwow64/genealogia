<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateTreeRequest;


class Update extends Controller
{

    public function __invoke(ValidateTreeRequest $request, Tree $tree)
    {
        $tree->update($request->validated());

        return ['message' => __('The tree was successfully updated')];
    }
}
