<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateNoteCardRequest extends FormRequest
{
    public function rules()
    {

        return parent::rules() + [
            'name' => 'required',
            'description' => 'required',
            'is_default' => 'required|boolean',
          ];
    }
}
