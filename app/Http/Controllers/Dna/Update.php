<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateDnaRequest;

class Update extends Controller
{
    public function __invoke(ValidateDnaRequest $request, Dna $dna)
    {
        $dna->update($request->validated());

        return ['message' => __('The dna was successfully updated')];
    }
}
