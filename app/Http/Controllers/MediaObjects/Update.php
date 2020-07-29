<?php

namespace App\Http\Controllers\MediaObjects;

use App\Http\Requests\ValidateMediaObjectRequest;
use App\MediaObject;
use Illuminate\Routing\Controller;

class Update extends Controller
{
    public function __invoke(ValidateMediaObjectRequest $request, MediaObject $mediaobject)
    {
        $mediaobject->update($request->validated());

        return ['message' => __('The media object was successfully updated')];
    }
}
