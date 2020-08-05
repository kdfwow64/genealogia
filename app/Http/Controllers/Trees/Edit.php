<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Routing\Controller;
use App\Forms\Builders\TreeForm;

class Edit extends Controller
{
    public function __invoke(Tree $tree, TreeForm $form)
    {
        return ['form' => $form->edit($tree)];
    }
}
