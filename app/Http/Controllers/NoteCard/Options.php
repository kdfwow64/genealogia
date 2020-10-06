<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use App\Http\Resources\OneLiner;
use App\Models\NoteCard;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected $resource = OneLiner::class;

    protected $queryAttributes = [
        'street', 'additional', 'locality.name', 'region.name',
        'region.abbreviation',
    ];

    public function query()
    {
        return NoteCard::ordered();
    }
}
