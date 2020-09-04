<?php

namespace App\Tables\Builders;

use App\Tree;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Tables\Contracts\Table;

class TreeTable implements Table
{

    protected const TemplatePath = __DIR__.'/../Templates/trees.json';

    public function query(): Builder
    {
        $user_id = Auth::user()->id;

        return Tree::where('trees.user_id', $user_id)->selectRaw('
            trees.id,
            trees.name,
            trees.description,
            trees.user_id
        ');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
