<?php

namespace App\Forms\Builders;

use App\Dna;
use LaravelEnso\Forms\Services\Form;

class DnaForm
{
    protected const TemplatePath = __DIR__.'/..\Templates//dna.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form(static::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Dna $dna)
    {
        return $this->form->edit($dna);
    }
}
