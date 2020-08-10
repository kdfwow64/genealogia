<?php

namespace App\Forms\Builders;

use App\Person;
use App\Traits\ConnectionTrait;
use LaravelEnso\Forms\Services\Form;

class PersonForm extends \LaravelEnso\People\Forms\Builders\PersonForm
{
    use ConnectionTrait;

    protected const TemplatePath = __DIR__.'/../Templates/person.json';

    protected Form $form;

    public function __construct()
    {
        $conn = $this->getConnection();
        $db = $this->getDB();
        $this->form = new Form(static::TemplatePath);
    }

    public function create()
    {
        $conn = $this->getConnection();
        $db = $this->getDB();
        return $this->form->create();
    }

    public function edit(Person $person)
    {
        $conn = $this->getConnection();
        $db = $this->getDB();

        if ($person->hasUser()) {
            $this->form->meta(
                'email',
                'tooltip',
                'Email can only be edited via the user form'
            )->readonly('email');
        }

        return $this->form
            ->value('company', optional($person->company())->id)
            ->append('userId', optional($person->user)->id)
            ->edit($person);
    }
}
