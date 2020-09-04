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
            people.birthday, people.deathday, CASE WHEN users.id is null THEN 0 ELSE 1 END as "user",
            companies.name as company, people.created_at');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }

}
