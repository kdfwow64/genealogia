<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForDnas extends Migration
{
    protected $permissions = [
        ['name' => 'dna.index', 'description' => 'Show index for dnas', 'is_default' => false],

        ['name' => 'dna.create', 'description' => 'Create dna', 'is_default' => false],
        ['name' => 'dna.store', 'description' => 'Store a new dna', 'is_default' => false],
        ['name' => 'dna.show', 'description' => 'Show dna', 'is_default' => false],
        ['name' => 'dna.edit', 'description' => 'Edit dna', 'is_default' => false],
        ['name' => 'dna.update', 'description' => 'Update dna', 'is_default' => false],
        ['name' => 'dna.destroy', 'description' => 'Delete dna', 'is_default' => false],
        ['name' => 'dna.initTable', 'description' => 'Init table for dnas', 'is_default' => false],

        ['name' => 'dna.tableData', 'description' => 'Get table data for dnas', 'is_default' => false],

        ['name' => 'dna.exportExcel', 'description' => 'Export excel for dnas', 'is_default' => false],

        ['name' => 'dna.options', 'description' => 'Get dna options for select', 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'DNA', 'icon' => 'book', 'route' => 'dna.index', 'order_index' => 999, 'has_children' => false
    ];

    protected $parentMenu = '';
}

