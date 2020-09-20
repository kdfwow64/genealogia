<?php

namespace App\Http\Controllers\Dnamatching;

use Illuminate\Routing\Controller;
use App\Forms\Builders\DnaMatchingForm;

class Create extends Controller
{
    public function __invoke(DnaMatchingForm $form)
    {
        return ['form' => $form->create()];
    }
}
