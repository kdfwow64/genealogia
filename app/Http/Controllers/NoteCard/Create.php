<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Forms\Builders\NoteCardForm;

class Create extends Controller
{
    public function __invoke(Request $request, NoteCardForm $form)
    {
        return ['form' => $form->create()];
    }
}
