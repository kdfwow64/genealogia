<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Forms\Builders\NoteCardForm;
use App\Models\NoteCard;

class Edit extends Controller
{
    public function __invoke(Request $request, NoteCard $notecard, NoteCardForm $form)
    {
        return ['form' => $form->edit($notecard)];
    }
}
