<?php

namespace App\Tables\Builders;

use App\Person;
use App\Traits\ConnectionTrait;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;


class PersonTable extends \LaravelEnso\People\Tables\Builders\PersonTable
{
    use ConnectionTrait;

    protected const TemplatePath = __DIR__.'/../Templates/people.json';

    public function query(): Builder
    {
        $conn = $this->getConnection();
        $db = $this->getDB();

        return Person::on($conn)->selectRaw('
            people.id
            , people.title, people.givn, people.surn,  people.appellative, people.email, people.phone,
            people.birthday, people.deathday, people.created_at');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }

}
