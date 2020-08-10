<?php

namespace App\Providers;

use App\DynamicRelations\Company\Comments;
use App\DynamicRelations\Company\Discussions;
use App\DynamicRelations\Company\Documents;
use App\Forms\Builders\PersonForm as LocalPersonForm;
use App\Http\Requests\ValidatePersonRequest as LocalPersonRequest;
use App\Models\User;
use App\Person as LocalPerson;
use App\Tables\Builders\PersonTable as LocalPersonTable;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Models\User as BaseUser;
use LaravelEnso\DynamicMethods\Services\Methods;
use LaravelEnso\People\Forms\Builders\PersonForm;
use LaravelEnso\People\Http\Requests\ValidatePersonRequest;
use LaravelEnso\People\Models\Person;
use LaravelEnso\People\Tables\Builders\PersonTable;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        BaseUser::class => User::class,
    ];

    public function boot()
    {
        $this->app->bind(ValidatePersonRequest::class, function () {
            return new LocalPersonRequest();
        });
        $this->app->bind(Person::class, function () {
            return new LocalPerson();
        });
        $this->app->bind(PersonTable::class, function () {
            return new LocalPersonTable();
        });
        $this->app->bind(PersonForm::class, function () {
            return new LocalPersonForm();
        });
    }

    public function register()
    {
        Methods::bind(Company::class, [Comments::class, Discussions::class, Documents::class]);
        // Methods::bind(User::class, [ActionLogs::class]);
    }
}
