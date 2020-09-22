<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForDnaMatchings extends Migration
{
    protected array $permissions = [
        ['name' => 'dnamatching.index', 'description' => 'Show index for dna matchings', 'is_default' => false],

        ['name' => 'dnamatching.show', 'description' => 'Show dna matching', 'is_default' => false],
        ['name' => 'dnamatching.initTable', 'description' => 'Init table for dna matchings', 'is_default' => false],

        ['name' => 'dnamatching.tableData', 'description' => 'Get table data for dna matchings', 'is_default' => false],

    ];

    protected array $menu = [
        'name' => 'DNA Matching', 'icon' => 'book', 'route' => 'dnamatching.index', 'order_index' => 999, 'has_children' => false
    ];

    protected ?string $parentMenu = '';
}

