<?php

namespace App\Http\Controllers\Trees;

use Illuminate\Routing\Controller;
use App\Forms\Builders\TreeForm;
use Illuminate\Support\Facades\Auth;
use App\Tree;

class Create extends Controller
{
    public function __invoke(TreeForm $form)
    {
        $user = Auth::user();

        if ($user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
            if(Tree::where('user_id', '=', $user->user_id)->count() < 1){
                return ['form' => $form->create()];
            }
        }

        if ($user->role_id == 6 || $user->role_id == 7) {
            if(Tree::where('user_id', '=', $user->user_id)->count() < 10){
                return ['form' => $form->create()];
            }
        }

        if ($user->role_id == 1 || $user->role_id == 8 || $user->role_id == 9) {
            return ['form' => $form->create()];
        }


    }
}
