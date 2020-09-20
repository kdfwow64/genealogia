<?php

namespace App\Http\Controllers\Dnamatching;

use App\Dnamatching;
use Illuminate\Routing\Controller;
use App\Forms\Builders\DnaMatchingForm;

class Edit extends Controller
{
    public function __invoke(Dnamatching $Dnamatching, DnaMatchingForm $form)
    {
        return ['form' => $form->edit($dna)];
    }
}
