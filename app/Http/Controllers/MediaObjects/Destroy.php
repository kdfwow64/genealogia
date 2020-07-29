<?php

namespace App\Http\Controllers\MediaObjects;

use App\MediaObject;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(MediaObject $mediaobject)
    {
        $mediaobject->delete();

        return [
            'message' => __('The media object was successfully deleted'),
            'redirect' => 'mediaobjects.index',
        ];
    }
}
