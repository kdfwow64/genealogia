<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use LaravelEnso\NoteCardes\Http\Requests\ValidateNoteCardRequest;
use App\Models\NoteCard;

class Update extends Controller
{
    public function __invoke(ValidateNoteCardRequest $request, NoteCard $notecard)
    {
        $notecard->fill($request->validated())->store();

        return ['message' => __('The note has been successfully updated')];
    }
}
