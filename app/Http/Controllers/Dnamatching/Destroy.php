<?php

namespace App\Http\Controllers\Dnamatching;

use App\DnaMatching;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(DnaMatching $dnamatching)
    {
        $dnamatching->delete();

        return [
            'message' => __('The DNA Matching was successfully deleted'),
            'redirect' => 'dna.index',
        ];
    }
}
