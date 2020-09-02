<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(Dna $dna)
    {
        $dna->delete();

        return [
            'message' => __('The dna was successfully deleted'),
            'redirect' => 'dna.index',
        ];
    }
}
