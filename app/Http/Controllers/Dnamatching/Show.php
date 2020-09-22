<?php

namespace App\Http\Controllers\Dnamatching;

use App\DnaMatching;
use Illuminate\Routing\Controller;

class Show extends Controller
{
    public function __invoke(DnaMatching $dnaMatching)
    {
        return ['dnaMatching' => $dnaMatching];
    }
}
