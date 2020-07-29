<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForTrees extends Migration
{
    protected array $permissions = [
        ['name' => 'trees.index', 'description' => 'Show index for trees', 'is_default' => false],
        ['name' => 'trees.create', 'description' => 'Create tree', 'is_default' => false],
        ['name' => 'trees.store', 'description' => 'Store a new tree', 'is_default' => false],
        ['name' => 'trees.edit', 'description' => 'Edit tree', 'is_default' => false],
        ['name' => 'trees.update', 'description' => 'Update tree', 'is_default' => false],
        ['name' => 'trees.destroy', 'description' => 'Delete tree', 'is_default' => false],
        ['name' => 'trees.initTable', 'description' => 'Init table for trees', 'is_default' => false],
        ['name' => 'trees.tableData', 'description' => 'Get table data for trees', 'is_default' => false],
        ['name' => 'trees.exportExcel', 'description' => 'Export excel for trees', 'is_default' => false],
        ['name' => 'trees.options', 'description' => 'Get tree options for select', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Trees', 'icon' => 'eye', 'route' => 'trees.index', 'order_index' => 999, 'has_children' => false
    ];

    protected ?string $parentMenu = 'Administration';
}

