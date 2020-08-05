<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForMediaObjects extends Migration
{
    protected array $permissions = [
        ['name' => 'mediaobjects.index', 'description' => 'Show index for objects', 'is_default' => false],

        ['name' => 'mediaobjects.create', 'description' => 'Create object', 'is_default' => false],
        ['name' => 'mediaobjects.store', 'description' => 'Store a new object', 'is_default' => false],
        ['name' => 'mediaobjects.show', 'description' => 'Show object', 'is_default' => false],
        ['name' => 'mediaobjects.edit', 'description' => 'Edit object', 'is_default' => false],
        ['name' => 'mediaobjects.update', 'description' => 'Update object', 'is_default' => false],
        ['name' => 'mediaobjects.destroy', 'description' => 'Delete object', 'is_default' => false],
        ['name' => 'mediaobjects.initTable', 'description' => 'Init table for objects', 'is_default' => false],

        ['name' => 'mediaobjects.tableData', 'description' => 'Get table data for objects', 'is_default' => false],

        ['name' => 'mediaobjects.exportExcel', 'description' => 'Export excel for objects', 'is_default' => false],

        ['name' => 'mediaobjects.options', 'description' => 'Get object options for select', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Objects', 'icon' => 'book', 'route' => 'mediaobjects.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'Information';
}
