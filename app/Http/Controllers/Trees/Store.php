<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateTreeRequest;

class Store extends Controller
{
    public function __invoke(ValidateTreeRequest $request, Tree $tree)
    {
        $tree->fill($request->validated())->save();

        return [
            'message' => __('The tree was successfully created'),
            'redirect' => 'trees.edit',
            'param' => ['tree' => $tree->id],
        ];
    }
}
