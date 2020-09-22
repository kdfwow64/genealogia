<?php

namespace App\Http\Controllers\Dnamatching;

use App\Tables\Builders\DnaMatchingTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected string $tableClass = DnaMatchingTable::class;
}