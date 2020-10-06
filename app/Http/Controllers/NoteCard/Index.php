<?php

namespace App\Http\Controllers\NoteCard;

use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateNoteCardFetch;
use App\Http\Resources\NoteCard as Resource;
use App\Models\NoteCard;

class Index extends Controller
{
    public function __invoke(ValidateNoteCardFetch $request)
    {
        return Resource::collection(
            NoteCard::for($request->get('notecard_id'), $request->get('notecard_type'))
                ->ordered()
                ->get()
        );
    }
}
