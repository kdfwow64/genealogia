<?php

namespace App\Http\Controllers\Dnamatching;

use App\DnaMatching;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected string $model = DnaMatching::class;

    //protected $queryAttributes = ['name'];

    //public function query(Request $request)
    //{
    //    return DnaMatching::query();
    //}
}
