<?php

namespace App\Http\Controllers\Trees;

use App\Tables\Builders\TreeTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected string $tableClass = TreeTable::class;
}
