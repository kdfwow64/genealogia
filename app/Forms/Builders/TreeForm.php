<?php

namespace App\Forms\Builders;

use App\Tree;
use LaravelEnso\Forms\Services\Form;

class TreeForm
{
    protected const TemplatePath = __DIR__.'/../Templates/tree.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form(static::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Tree $tree)
    {
        $this->form->actions(['back', 'destroy', 'show']);
        return $this->form->edit($tree);
    }
}
