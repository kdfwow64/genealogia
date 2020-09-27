<?php

namespace App\Tables\Builders;

use App\DnaMatching;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Tables\Contracts\CustomFilter;

class DnaMatchingTable implements Table, CustomFilter
{
    protected const TemplatePath = __DIR__.'/../Templates/dnaMatchings.json';

    public function query(): Builder
    {
        $user = auth()->user();
        return DnaMatching::where('user_id', '=', $user->id)->selectRaw('
            dna_matchings.id,
            dna_matchings.image,
            dna_matchings.file1,
            dna_matchings.file2,
            dna_matchings.total_shared_cm,
            dna_matchings.largest_cm_segment
        ');
    }

    public function filterApplies(Obj $params): bool
    {
        return $params->filled('cm') ?? false;
    }

    public function filter(Builder $query, Obj $params)
    {
        return $query->when(
            $params->get('cm'),
            fn($query) => $query->where('largest_cm_segment', '>=', $params->get('cm'))
        );
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
