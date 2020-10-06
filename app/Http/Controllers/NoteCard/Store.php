<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use Exceptions\NoteCard as Exception;
use App\Http\Requests\ValidateNoteCardRequest;
use App\Models\NoteCard;

class Store extends Controller
{
    public function __invoke(ValidateNoteCardRequest $request, NoteCard $notecard)
    {
        $notecard->fill($request->validated());

        if ($notecard->shouldBeSingle()) {
            throw Exception::cannotHaveMultiple();
        }

        $notecard->store();

        return [
            'message' => __('The note was successfully created'),
            'note_id' => $notecard->id,
        ];
    }
}
