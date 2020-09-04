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
        $user = Auth::user();

        return Tree::selectRaw('
            trees.id,
            trees.name,
            trees.description
        ')->where(trees.user_id === $user->id);
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
