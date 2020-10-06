<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForNoteCard extends Migration
{
    protected array $permissions = [
        ['name' => 'core.notes.update', 'description' => 'Update edited address', 'is_default' => false],
        ['name' => 'core.notes.store', 'description' => 'Store newly created address', 'is_default' => false],
        ['name' => 'core.notes.destroy', 'description' => 'Delete address', 'is_default' => false],
        ['name' => 'core.notes.index', 'description' => 'Get notes for addressable', 'is_default' => false],
        ['name' => 'core.notes.makeDefault', 'description' => 'Make address as default', 'is_default' => false],
        ['name' => 'core.notes.makeShipping', 'description' => 'Make address as shipping', 'is_default' => false],
        ['name' => 'core.notes.makeBilling', 'description' => 'Make address as billing', 'is_default' => false],
        ['name' => 'core.notes.show', 'description' => 'Get address', 'is_default' => false],
        ['name' => 'core.notes.edit', 'description' => 'Get Edit Form', 'is_default' => false],
        ['name' => 'core.notes.localize', 'description' => 'Localize address with google maps', 'is_default' => false],
        ['name' => 'core.notes.create', 'description' => 'Get Create Form', 'is_default' => false],
        ['name' => 'core.notes.options', 'description' => 'Get notes for select', 'is_default' => false],
        ['name' => 'core.notes.localities', 'description' => 'Get localities for the select', 'is_default' => false],
        ['name' => 'core.notes.regions', 'description' => 'Get regions for the select', 'is_default' => false],
        ['name' => 'core.notes.postcode', 'description' => 'Get address based on the postcode', 'is_default' => false],
    ];
}
