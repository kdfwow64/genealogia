<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;
use App\Forms\Builders\DnaForm;

class Edit extends Controller
{
    public function __invoke(Dna $dna, DnaForm $form)
    {

        $user = auth()->user();
        if ($user->id == $dna->user_id) {
            return ['form' => $form->edit($dna)];

        }
        else {

            return [
                'message' => __('The dna kit was could not be edited'),
                'redirect' => 'dna.index',
            ];

        }
    }
}
