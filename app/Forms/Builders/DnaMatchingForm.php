<?php

namespace App\Forms\Builders;

use App\DnaMatching;
use LaravelEnso\Forms\Services\Form;

class DnaMatchingForm
{
    protected const TemplatePath = __DIR__.'/..\Templates//dnaMatching.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form(static::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(DnaMatching $dnaMatching)
    {
        return $this->form->edit($dnaMatching);
    }
}
