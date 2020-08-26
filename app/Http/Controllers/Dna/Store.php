<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateDnaRequest;

class Store extends Controller
{
    public function __invoke(ValidateDnaRequest $request, Dna $dna)
    {
        $dna->fill($request->validated())->save();

        return [
            'message' => __('The dna was successfully created'),
            'redirect' => 'dna.edit',
            'param' => ['dna' => $dna->id],
        ];
    }
}
