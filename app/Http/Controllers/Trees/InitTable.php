<?php

namespace App\Http\Controllers\Trees;

use App\Tables\Builders\TreeTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected string $tableClass = TreeTable::class;
}
