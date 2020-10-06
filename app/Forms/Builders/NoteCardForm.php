<?php

namespace LaravelEnso\Addresses\Forms\Builders;

use Illuminate\Support\Facades\Config;
use App\NoteCard;
use LaravelEnso\Forms\Services\Form;

class AddressForm
{
    protected const TemplatePath = __DIR__.'/../Templates/notecard.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(static::TemplatePath));
    }

    public function create()
    {

        return $this->form
            ->title('Create')
            ->actions('store')
            ->create();
    }

    public function edit(NoteCard $notecard)
    {

        return $this->form
            ->title('Edit')
            ->actions('update')
            ->edit($notecard);
    }


    private function empty(NoteCard $notecard): NoteCard
    {
        $newNotecard = new NoteCard([
        ]);
        $newAddress->id = $notecard->id;

        return $notecard;
    }
}
