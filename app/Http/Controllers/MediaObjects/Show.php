<?php

namespace App\Http\Controllers\MediaObjects;

use App\MediaObject;
use Illuminate\Routing\Controller;

class Show extends Controller
{
    public function __invoke(MediaObject $mediaobject)
    {
        return ['mediaobject' => $mediaobject];
    }
}
