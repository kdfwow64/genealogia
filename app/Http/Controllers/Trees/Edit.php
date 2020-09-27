<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Routing\Controller;
use App\Forms\Builders\TreeForm;

class Edit extends Controller
{
    public function __invoke(Tree $tree, TreeForm $form)
    {

        $user = auth()->user();
        if ($user->id == $tree->user_id) {
            return ['form' => $form->edit($tree)];

        }
        else {

            return [
                'message' => __('The tree was could not be edited'),
                'redirect' => 'trees.index',
            ];

        }
    }
}
