<?php

namespace App\Http\Controllers\Trees;

use Illuminate\Routing\Controller;
use App\Forms\Builders\TreeForm;

class Create extends Controller
{
    public function __invoke(TreeForm $form)
    {
        return ['form' => $form->create()];
    }
}
