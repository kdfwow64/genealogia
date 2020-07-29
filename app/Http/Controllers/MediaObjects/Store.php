<?php

namespace App\Http\Controllers\MediaObjects;

use App\Http\Requests\ValidateMediaObjectRequest;
use App\MediaObject;
use Illuminate\Routing\Controller;

class Store extends Controller
{
    public function __invoke(ValidateMediaObjectRequest $request, MediaObject $mediaobject)
    {
        $mediaobject->fill($request->validated())->save();

        return [
            'message' => __('The media object was successfully created'),
            'redirect' => 'mediaobjects.edit',
            'param' => ['mediaobject' => $mediaobject->id],
        ];
    }
}
