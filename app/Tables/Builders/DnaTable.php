<?php

namespace App\Tables\Builders;

use App\Dna;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class DnaTable implements Table
{
    protected const TemplatePath = __DIR__.'/..\../Templates/dnas.json';

    public function query(): Builder
    {
        return Dna::selectRaw('
            dnas.id
        ');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
