<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(Dna $dna)
    {
        $user = auth()->user();
        if ($user->id == $dna->user_id) {


            $dna->delete();

            return [
                'message' => __('The dna was successfully deleted'),
                'redirect' => 'dna.index',
            ];
        }
        else {

            return [
                'message' => __('The dna could not be deleted'),
                'redirect' => 'dna.index',
            ];
        }
    }
}
