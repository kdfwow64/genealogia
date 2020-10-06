<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use Exceptions\NoteCard as Exception;
use App\Models\NoteCard;

class Destroy extends Controller
{
    public function __invoke(NoteCard $notecard)
    {
        if ($notecard->isDefault() && $notecard->isNotSingle()) {
            throw Exception::cannotRemoveDefault();
        }

        $notecard->delete();

        return ['message' => __('The note was deleted')];
    }
}
