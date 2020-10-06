<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use App\Http\Resources\NoteCard as Resource;
use App\Models\NoteCard;

class Show extends Controller
{
    public function __invoke(NoteCard $notecard)
    {
        return new Resource($notecard);
    }
}
