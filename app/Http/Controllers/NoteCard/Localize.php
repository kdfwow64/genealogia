<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use App\Models\NoteCard;

class Localize extends Controller
{
    public function __invoke(NoteCard $notecard)
    {
        return $notecard->localize();
    }
}
