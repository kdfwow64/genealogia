<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(Tree $tree)
    {
        $tree->delete();

        return [
            'message' => __('The tree was successfully deleted'),
            'redirect' => 'trees.index',
        ];
    }
}
