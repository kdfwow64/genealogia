<?php

namespace App\Http\Controllers\Trees;

use App\Tables\Builders\TreeTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected string $tableClass = TreeTable::class;
}
