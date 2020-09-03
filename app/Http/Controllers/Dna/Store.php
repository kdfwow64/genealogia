<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use App\Http\Requests\ValidateDnaRequest;
use App\Traits\ConnectionTrait;
use Auth;
use Illuminate\Routing\Controller;

class Store extends Controller
{
    use ConnectionTrait;

    public function __invoke(ValidateDnaRequest $request, Dna $dna)
    {
        $slug = $request->get('slug');
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                try {
                    $conn = $this->getConnection();
                    $db = $this->getDB();
                    $currentUser = Auth::user();
                    $_name = 'dna_' . uniqid() . '.' . $request->file('file')->extension();
                    $request->file->storeAs('dna', $_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    $filename = 'app/dna/' . $_name;
                    $dna->name = $_name;
                    $dna->save();
                    return [
                        'message' => __('The dna was successfully created'),
                        'redirect' => 'dna.edit',
                        'param' => ['dna' => $dna->id],
                    ];
                } catch (\Exception $e) {
                    return ['Not uploaded'];
                }
            }
            return ['File corrupted'];
        }
        return ['Not uploaded'];
    }
}
