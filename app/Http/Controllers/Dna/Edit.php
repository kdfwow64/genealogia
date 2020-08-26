<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;
use App\Forms\Builders\DnaForm;

class Edit extends Controller
{
    public function __invoke(Dna $dna, DnaForm $form)
    {
        return ['form' => $form->edit($dna)];
    }
}
