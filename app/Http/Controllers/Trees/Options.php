<?php

namespace App\Http\Controllers\Trees;

use App\Tree;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected string $model = Tree::class;

    //protected $queryAttributes = ['name'];

    //public function query(Request $request)
    //{
    //    return Tree::query();
    //}
}
