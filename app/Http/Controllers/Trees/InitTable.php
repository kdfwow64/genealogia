<?php

namespace App\Http\Controllers\Trees;

use App\Tables\Builders\TreeTable;
use App\Tree;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use LaravelEnso\Tables\Services\TemplateLoader;
use LaravelEnso\Tables\Traits\ProvidesRequest;

class InitTable extends Controller
{
    use ProvidesRequest;

    protected $tableClass = TreeTable::class;

    public function __invoke(Request $request)
    {
        $table = App::make($this->tableClass, [
            'request' => $this->request($request),
        ]);

        $template = (new TemplateLoader($table))->handle();

        $data = $template->toArray();

        $role_id = auth()->user()->role_id;

        $treeCount = Tree::count();

        if ($role_id == 2 || $role_id == 4 || $role_id == 5) { //Trial, OTM and OTY
            if($treeCount >= 1) {
                $data['template']->get('buttons')->get('global')->pop();
            }
        } else if($role_id == 6 || $role_id == 7) { //TTM and TTY
            if($treeCount >= 10) {
                $data['template']->get('buttons')->get('global')->pop();
            }
        }

        return $data;
    }
}
