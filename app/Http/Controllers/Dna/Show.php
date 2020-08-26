<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;

class Show extends Controller
{
    public function __invoke(Dna $dna)
    {
        return ['dna' => $dna];
    }
}
