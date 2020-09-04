<?php

namespace App\Tables\Builders;

use App\Tree;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class TreeTable implements Table
{

    protected const TemplatePath = __DIR__.'/../Templates/trees.json';

    public function query(): Builder
    {

        return Tree::selectRaw('
            trees.id,
            trees.name,
            trees.description
        ');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
