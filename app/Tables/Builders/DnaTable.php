<?php

namespace App\Tables\Builders;

use App\Dna;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class DnaTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/dnas.json';

    public function query(): Builder
    {

	 $user_id = Auth::user()->id;

        return Dna::where('dnas.user_id', $user_id)->selectRaw('
            dnas.variable_name,
            dnas.file_name
        ');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
