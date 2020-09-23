<?php

namespace App\Http\Controllers\Dna;

use App\Dna;
use App\Jobs\DnaMatching;
use App\Http\Requests\ValidateDnaRequest;
// use App\Traits\ConnectionTrait;
use Auth;
use Illuminate\Routing\Controller;

class Store extends Controller
{
//    use ConnectionTrait;

    public function __invoke(ValidateDnaRequest $request, Dna $dna)
    {
        $slug = $request->get('slug');
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                try {
//                    $conn = $this->getConnection();
//                    $db = $this->getDB();
                    $currentUser = Auth::user();
                    $file_name = 'dna_' . $request->file('file')->getClientOriginalName() . uniqid() . '.' . $request->file('file')->extension();
//                    $file_name = 'dna_' . $request->file('file')->getClientOriginalName() . uniqid() . '.csv';
                    $request->file->storeAs('dna', $file_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    $random_string = unique_random('dnas', 'variable_name', 5);
                    $var_name = 'var_' . $random_string; 
                    $filename = 'app/dna/' . $file_name;
                    $user_id = $currentUser->id;
		    $dna->name = 'DNA Kit for user ' . $user_id;
		    $dna->user_id = $user_id;
                    $dna->variable_name = $var_name;
                    $dna->file_name = $file_name;
                    $dna->save();
                    DnaMatching::dispatch($var_name, $file_name);
                    return [
                        'message' => __('The dna was successfully created'),
                        'redirect' => 'dna.edit',
                        'param' => ['dna' => $dna->id],
                    ];
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
            return ['File corrupted'];
        }
        return ['Not uploaded'];
    }
}
