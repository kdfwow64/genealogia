<?php

namespace App\Http\Controllers\Dna;

use Illuminate\Routing\Controller;
use App\Forms\Builders\DnaForm;

class Create extends Controller
{
    public function __invoke(DnaForm $form)
    {
        return ['form' => $form->create()];
    }
}
