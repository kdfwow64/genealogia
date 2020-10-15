<?php

use App\Http\Controllers\Dashboard\ChartController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\About\Index as AboutIndex;
use App\Http\Controllers\Privacy\Index as PrivacyIndex;
use App\Http\Controllers\Termsandconditions\Index as TermsandconditionsIndex;
use App\Http\Controllers\Contact\Index as ContactIndex;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Citations\Create as CitationsCreate;
use App\Http\Controllers\Citations\Destroy as CitationsDestroy;
use App\Http\Controllers\Citations\Edit as CitationsEdit;
use App\Http\Controllers\Citations\ExportExcel as CitationsExportExcel;
use App\Http\Controllers\Citations\InitTable as CitationsInitTable;
use App\Http\Controllers\Citations\Options as CitationsOptions;
use App\Http\Controllers\Citations\Store as CitationsStore;
use App\Http\Controllers\Citations\TableData as CitationsTableData;
use App\Http\Controllers\Citations\Update as CitationsUpdate;

use App\Http\Controllers\Families;
use App\Http\Controllers\Notes;
use App\Http\Controllers\Places;
use App\Http\Controllers\Repositories;
use App\Http\Controllers\Sources;
use App\Http\Controllers\Types;
use App\Http\Controllers\Authors;
use App\Http\Controllers\Publications;
use App\Http\Controllers\Gedcom;
use App\Http\Controllers\MediaObjects;
use App\Http\Controllers\Addrs;
use App\Http\Controllers\Chan;
use App\Http\Controllers\Familyevents;
use App\Http\Controllers\Familyslugs;
use App\Http\Controllers\Personalias;
use App\Http\Controllers\Personanci;
use App\Http\Controllers\Personasso;
use App\Http\Controllers\Personevent;
use App\Http\Controllers\Personlds;
use App\Http\Controllers\PersonSubm;
use App\Http\Controllers\Refn;
use App\Http\Controllers\Sourcedata;
use App\Http\Controllers\Sourcedataevent;
use App\Http\Controllers\Sourcerefevents;
use App\Http\Controllers\Subm;
use App\Http\Controllers\Subn;
use App\Http\Controllers\Trees;
use App\Http\Controllers\Dna;
use App\Http\Controllers\Dnamatching;
use App\Http\Controllers\NoteCard;


use LaravelEnso\Addresses\Http\Controllers\Create as AddressCreate;
use LaravelEnso\Addresses\Http\Controllers\Destroy as AddressDestroy;
use LaravelEnso\Addresses\Http\Controllers\Edit as AddressEdit;
use LaravelEnso\Addresses\Http\Controllers\Index as AddressIndex;
use LaravelEnso\Addresses\Http\Controllers\Localities;
use LaravelEnso\Addresses\Http\Controllers\Localize as AddressLocalize;
use LaravelEnso\Addresses\Http\Controllers\MakeBilling as AddressMakeBilling;
use LaravelEnso\Addresses\Http\Controllers\MakeDefault as AddressMakeDefault;
use LaravelEnso\Addresses\Http\Controllers\MakeShipping as AddressMakeShipping;
use LaravelEnso\Addresses\Http\Controllers\Options as AddressOptions;
use LaravelEnso\Addresses\Http\Controllers\Postcode;
use LaravelEnso\Addresses\Http\Controllers\Regions;
use LaravelEnso\Addresses\Http\Controllers\Show as AddressShow;
use LaravelEnso\Addresses\Http\Controllers\Store as AddressStore;
use LaravelEnso\Addresses\Http\Controllers\Update as AddressUpdate;

use LaravelEnso\Calendar\Http\Controllers\Calendar\Create as CalendarCreate;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Destroy as CalendarDestroy;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Edit as CalendarEdit;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Index as CalendarIndex;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Options as CalendarOptions;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Store as CalendarStore;
use LaravelEnso\Calendar\Http\Controllers\Calendar\Update as CalendarUpdate;

use LaravelEnso\Calendar\Http\Controllers\Events\Create as EventCreate;
use LaravelEnso\Calendar\Http\Controllers\Events\Destroy as EventDestroy;
use LaravelEnso\Calendar\Http\Controllers\Events\Edit as EventEdit;
use LaravelEnso\Calendar\Http\Controllers\Events\Index as EventIndex;
use LaravelEnso\Calendar\Http\Controllers\Events\Store as EventStore;
use LaravelEnso\Calendar\Http\Controllers\Events\Update as EventUpdate;

use LaravelEnso\People\Http\Controllers\Create as PeopleCreate;
use LaravelEnso\People\Http\Controllers\Destroy as PeopleDestroy;
use LaravelEnso\People\Http\Controllers\Edit as PeopleEdit;
use LaravelEnso\People\Http\Controllers\ExportExcel as PeopleExportExcel;
use LaravelEnso\People\Http\Controllers\InitTable as PeopleInitTable;
use LaravelEnso\People\Http\Controllers\Options as PeopleOptions;
use LaravelEnso\People\Http\Controllers\Store as PeopleStore;
use LaravelEnso\People\Http\Controllers\TableData as PeopleTableData;
use LaravelEnso\People\Http\Controllers\Update as PeopleUpdate;

use LaravelEnso\Companies\Http\Controllers\Company\Create as CompanyCreate;
use LaravelEnso\Companies\Http\Controllers\Company\Destroy as CompanyDestroy;
use LaravelEnso\Companies\Http\Controllers\Company\Edit as CompanyEdit;
use LaravelEnso\Companies\Http\Controllers\Company\ExportExcel as CompanyExportExcel;
use LaravelEnso\Companies\Http\Controllers\Company\InitTable as CompanyInitTable;
use LaravelEnso\Companies\Http\Controllers\Company\Options as CompanyOptions;
use LaravelEnso\Companies\Http\Controllers\Company\Store as CompanyStore;
use LaravelEnso\Companies\Http\Controllers\Company\TableData as CompanyTableData;
use LaravelEnso\Companies\Http\Controllers\Company\Update as CompanyUpdate;

use LaravelEnso\Companies\Http\Controllers\Person\Create as PeopleCompanyCreate;
use LaravelEnso\Companies\Http\Controllers\Person\Destroy as PeopleCompanyDestroy;
use LaravelEnso\Companies\Http\Controllers\Person\Edit as PeopleCompanyEdit;
use LaravelEnso\Companies\Http\Controllers\Person\Index as PeopleCompany;
use LaravelEnso\Companies\Http\Controllers\Person\Store as PeopleCompanyStore;
use LaravelEnso\Companies\Http\Controllers\Person\Update as PeopleCompanyUpdate;


Route::get('get-plans', [StripeController::class, 'getPlans']);

Route::get('get-current-subscription', [StripeController::class, 'getCurrentSubscription'])->middleware(['auth']);

Route::get('get-intent', [StripeController::class, 'getIntent'])->middleware(['auth']);
Route::post('subscribe', [StripeController::class, 'subscribe'])->middleware(['auth']);
Route::post('unsubscribe', [StripeController::class, 'unsubscribe'])->middleware(['auth']);
Route::post('webhook', [StripeController::class, 'webhook'])->middleware([VerifyWebhookSignature::class]);

     Route::middleware(['guest'])
	->prefix('api')
	->group(
         function() {

        Route::namespace('About')
            ->prefix('about')
            ->as('about.')
            ->group(function () {
                Route::get('about', [AboutIndex::class, 'index'])->name('index');
    });
        Route::namespace('Termsandconditions')
            ->prefix('termsandconditions')
            ->as('termsandconditions.')
            ->group(function () {
                Route::get('termsandconditions', [TermsandconditionsIndex::class, 'index'])->name('index');
    });
        Route::namespace('Privacy')
            ->prefix('privacy')
            ->as('privacy.')
            ->group(function () {
                Route::get('privacy', [PrivacyIndex::class, 'index'])->name('index');
    });
        Route::namespace('Contact')
            ->prefix('contact')
            ->as('contact.')
            ->group(function () {
                Route::get('contact', [ContactIndex::class, 'index'])->name('index');
    });
});

Route::namespace('Auth')
    ->middleware('api')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::post('login', [LoginController::class, 'login'])->name('login');
        });

        Route::middleware('auth')->group(function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        });
    });

    // Route::middleware(['api'])->group(
    //     function() {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('verify', [RegisterController::class, 'verify_user']);
    //     }
    // );

        // example data for the dashboard
Route::middleware(['web', 'auth', 'multitenant'])
    ->namespace('Dashboard')
    ->prefix('dashboard')->as('dashboard.')
    ->group(function () {
        Route::get('line', [ChartController::class, 'line'])
            ->name('line');
        Route::get('bar', [ChartController::class, 'bar'])
            ->name('bar');
        Route::get('pie', [ChartController::class, 'pie'])
            ->name('pie');
        Route::get('doughnut', [ChartController::class, 'doughnut'])
            ->name('doughnut');
        Route::get('radar', [ChartController::class, 'radar'])
            ->name('radar');
        Route::get('polar', [ChartController::class, 'polar'])
            ->name('polar');
        Route::get('bubble', [ChartController::class, 'bubble'])
            ->name('bubble');
        Route::post('changedb', [ChartController::class, 'changedb'])
            ->name('changedb');
        Route::post('getdb', [ChartController::class, 'getDB'])
            ->name('getdb');
        Route::get('trial', [ChartController::class, 'trial'])
            ->name('trial');
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Citations')
            ->prefix('citations')
            ->as('citations.')
            ->group(function () {
                Route::get('', [CitationsIndex::class, 'index']);
                Route::get('create', [CitationsCreate::class, 'create']);
                Route::post('', [CitationsStore::class, 'store']);
                Route::get('{citation}/edit', [CitationsEdit::class, 'edit']);

                Route::patch('{citation}', [CitationsUpdate::class, 'update']);

                Route::delete('{citation}', [CitationsDestroy::class, 'destroy']);

                Route::get('initTable', [CitationsInitTable::class, 'initTable']);
                Route::get('tableData', [CitationsTableData::class, 'tableData']);
                Route::get('exportExcel', [CitationsExportExcel::class, 'exportExcel']);

                Route::get('options', [CitationsOptions::class, 'options']);
                Route::get('{citation}', [CitationsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Families')
            ->prefix('families')
            ->as('families.')
            ->group(function () {
                Route::get('', [Family::class, 'index']);
                Route::get('create', [Family::class, 'create']);
                Route::post('', [Family::class, 'store']);
                Route::get('{family}/edit', [Family::class, 'edit']);

                Route::patch('{family}', [Family::class, 'update']);

                Route::delete('{family}', [Family::class, 'destroy']);

                Route::get('initTable', [Family::class, 'initTable']);
                Route::get('tableData', [Family::class, 'tableData']);
                Route::get('exportExcel', [Family::class, 'exportExcel']);

                Route::get('options', [Family::class, 'options']);
                Route::get('{family}', [Family::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Notes')
            ->prefix('notes')
            ->as('notes.')
            ->group(function () {
                Route::get('', [Note::class, 'index']);
                Route::get('create', [Note::class, 'create']);
                Route::post('', [Note::class, 'store']);
                Route::get('{note}/edit', [Note::class, 'edit']);

                Route::patch('{note}', [Note::class, 'update']);

                Route::delete('{note}', [Note::class, 'destroy']);

                Route::get('initTable', [Note::class, 'initTable']);
                Route::get('tableData', [Note::class, 'tableData']);
                Route::get('exportExcel', [Note::class, 'exportExcel']);

                Route::get('options', [Note::class, 'options']);
                Route::get('{note}', [Note::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Places')
            ->prefix('places')
            ->as('places.')
            ->group(function () {
                Route::get('', [Place::class, 'index']);
                Route::get('create', [Place::class, 'create']);
                Route::post('', [Place::class, 'store']);
                Route::get('{place}/edit', [Place::class, 'edit']);

                Route::patch('{place}', [Place::class, 'update']);

                Route::delete('{place}', [Place::class, 'destroy']);

                Route::get('initTable', [Place::class, 'initTable']);
                Route::get('tableData', [Place::class, 'tableData']);
                Route::get('exportExcel', [Place::class, 'exportExcel']);

                Route::get('options', [Place::class, 'options']);
                Route::get('{place}', [Place::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Repositories')
            ->prefix('repositories')
            ->as('repositories.')
            ->group(function () {
                Route::get('', [Repostiories::class, 'index']);
                Route::get('create', [Repostiories::class, 'create']);
                Route::post('', [Repostiories::class, 'store']);
                Route::get('{repository}/edit', [Repostiories::class, 'edit']);

                Route::patch('{repository}', [Repostiories::class, 'update']);

                Route::delete('{repository}', [Repostiories::class, 'destroy']);

                Route::get('initTable', [Repostiories::class, 'initTable']);
                Route::get('tableData', [Repostiories::class, 'tableData']);
                Route::get('exportExcel', [Repostiories::class, 'exportExcel']);

                Route::get('options', [Repostiories::class, 'options']);
                Route::get('{repository}', [Repostiories::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sources')
            ->prefix('sources')
            ->as('sources.')
            ->group(function () {
                Route::get('', [Sources::class, 'index']);
                Route::get('create', [Sources::class, 'create']);
                Route::post('', [Sources::class, 'store']);
                Route::get('{source}/edit', [Sources::class, 'edit']);

                Route::patch('{source}', [Sources::class, 'update']);

                Route::delete('{source}', [Sources::class, 'destroy']);

                Route::get('initTable', [Sources::class, 'initTable']);
                Route::get('tableData', [Sources::class, 'tableData']);
                Route::get('exportExcel', [Sources::class, 'exportExcel']);

                Route::get('options', [Sources::class, 'options']);
                Route::get('{source}', [Sources::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Types')
            ->prefix('types')
            ->as('types.')
            ->group(function () {
                Route::get('', [Types::class, 'index']);
                Route::get('create', [Types::class, 'create']);
                Route::post('', [Types::class, 'store']);
                Route::get('{type}/edit', [Types::class, 'edit']);

                Route::patch('{type}', [Types::class, 'update']);

                Route::delete('{type}', [Types::class, 'destroy']);

                Route::get('initTable', [Types::class, 'initTable']);
                Route::get('tableData', [Types::class, 'tableData']);
                Route::get('exportExcel', [Types::class, 'exportExcel']);

                Route::get('options', [Types::class, 'options']);
                Route::get('{type}', [Types::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Authors')
            ->prefix('authors')
            ->as('authors.')
            ->group(function () {
                Route::get('', [Authors::class, 'index']);
                Route::get('create', [Authors::class, 'create']);
                Route::post('', [Authors::class, 'store']);
                Route::get('{author}/edit', [Authors::class, 'edit']);

                Route::patch('{author}', [Authors::class, 'update']);

                Route::delete('{author}', [Authors::class, 'destroy']);

                Route::get('initTable', [Authors::class, 'initTable']);
                Route::get('tableData', [Authors::class, 'tableData']);
                Route::get('exportExcel', [Authors::class, 'exportExcel']);

                Route::get('options', [Authors::class, 'options']);
                Route::get('{author}', [Authors::class, 'show']);
            });
    });
Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Publications')
            ->prefix('publications')
            ->as('publications.')
            ->group(function () {
                Route::get('', [Publications::class, 'index']);
                Route::get('create', [Publications::class, 'create']);
                Route::post('', [Publications::class, 'store']);
                Route::get('{publication}/edit', [Publications::class, 'edit']);

                Route::patch('{publication}', [Publications::class, 'update']);

                Route::delete('{publication}', [Publications::class, 'destroy']);

                Route::get('initTable', [Publications::class, 'initTable']);
                Route::get('tableData', [Publications::class, 'tableData']);
                Route::get('exportExcel', [Publications::class, 'exportExcel']);

                Route::get('options', [Publications::class, 'options']);
                Route::get('{publication}', [Publications::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Gedcom')
            ->prefix('gedcom')
            ->as('gedcom.')
            ->group(function () {
                Route::post('store', [Gedcom::class, 'store']);
            });
    });

Route::get('gedcom/progress', '\App\Http\Controllers\Gedcom\Progress@index')->name('progress');

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('MediaObjects')
            ->prefix('mediaobjects')
            ->as('mediaobjects.')
            ->group(function () {
                Route::get('', [MediaObjects::class, 'index']);
                Route::get('create', [MediaObjects::class, 'create']);
                Route::post('', [MediaObjects::class, 'store']);
                Route::get('{mediaobjects}/edit', [MediaObjects::class, 'edit']);

                Route::patch('{mediaobjects}', [MediaObjects::class, 'update']);

                Route::delete('{mediaobjects}', [MediaObjects::class, 'destroy']);

                Route::get('initTable', [MediaObjects::class, 'initTable']);
                Route::get('tableData', [MediaObjects::class, 'tableData']);
                Route::get('exportExcel', [MediaObjects::class, 'exportExcel']);

                Route::get('options', [MediaObjects::class, 'options']);
                Route::get('{mediaobject}', [MediaObjects::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Addrs')
            ->prefix('addrs')
            ->as('addrs.')
            ->group(function () {
                Route::get('', [Addrs::class, 'index']);
                Route::get('create', [Addrs::class, 'create']);
                Route::post('', [Addrs::class, 'store']);
                Route::get('{addr}/edit', [Addrs::class, 'edit']);

                Route::patch('{addr}', [Addrs::class, 'update']);

                Route::delete('{addr}', [Addrs::class, 'destroy']);

                Route::get('initTable', [Addrs::class, 'initTable']);
                Route::get('tableData', [Addrs::class, 'tableData']);
                Route::get('exportExcel', [Addrs::class, 'exportExcel']);

                Route::get('options', [Addrs::class, 'options']);
                Route::get('{addr}', [Addrs::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Chan')
            ->prefix('chan')
            ->as('chan.')
            ->group(function () {
                Route::get('', [Chan::class, 'index']);
                Route::get('create', [Chan::class, 'create']);
                Route::post('', [Chan::class, 'store']);
                Route::get('{chan}/edit', [Chan::class, 'edit']);

                Route::patch('{chan}', [Chan::class, 'update']);

                Route::delete('{chan}', [Chan::class, 'destroy']);

                Route::get('initTable', [Chan::class, 'initTable']);
                Route::get('tableData', [Chan::class, 'tableData']);
                Route::get('exportExcel', [Chan::class, 'exportExcel']);

                Route::get('options', [Chan::class, 'options']);
                Route::get('{chan}', [Chan::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Familyevents')
            ->prefix('familyevents')
            ->as('familyevents.')
            ->group(function () {
                Route::get('', [Familyevents::class, 'index']);
                Route::get('create', [Familyevents::class, 'create']);
                Route::post('', [Familyevents::class, 'store']);
                Route::get('{familyEvent}/edit', [Familyevents::class, 'edit']);

                Route::patch('{familyEvent}', [Familyevents::class, 'update']);

                Route::delete('{familyEvent}', [Familyevents::class, 'destroy']);

                Route::get('initTable', [Familyevents::class, 'initTable']);
                Route::get('tableData', [Familyevents::class, 'tableData']);
                Route::get('exportExcel', [Familyevents::class, 'exportExcel']);

                Route::get('options', [Familyevents::class, 'options']);
                Route::get('{familyEvent}', [Familyevents::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Familyslugs')
            ->prefix('familyslugs')
            ->as('familyslugs.')
            ->group(function () {
                Route::get('', [Familyslugs::class, 'index']);
                Route::get('create', [Familyslugs::class, 'create']);
                Route::post('', [Familyslugs::class, 'store']);
                Route::get('{familySlgs}/edit', [Familyslugs::class, 'edit']);

                Route::patch('{familySlgs}', [Familyslugs::class, 'update']);

                Route::delete('{familySlgs}', [Familyslugs::class, 'destroy']);

                Route::get('initTable', [Familyslugs::class, 'initTable']);
                Route::get('tableData', [Familyslugs::class, 'tableData']);
                Route::get('exportExcel', [Familyslugs::class, 'exportExcel']);

                Route::get('options', [Familyslugs::class, 'options']);
                Route::get('{familySlgs}', [Familyslugs::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personalias')
            ->prefix('personalias')
            ->as('personalias.')
            ->group(function () {
                Route::get('', [Personalias::class, 'index']);
                Route::get('create', [Personalias::class, 'create']);
                Route::post('', [Personalias::class, 'store']);
                Route::get('{personAlia}/edit', [Personalias::class, 'edit']);

                Route::patch('{personAlia}', [Personalias::class, 'update']);

                Route::delete('{personAlia}', [Personalias::class, 'destroy']);

                Route::get('initTable', [Personalias::class, 'initTable']);
                Route::get('tableData', [Personalias::class, 'tableData']);
                Route::get('exportExcel', [Personalias::class, 'exportExcel']);

                Route::get('options', [Personalias::class, 'options']);
                Route::get('{personAlia}', [Personalias::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personanci')
            ->prefix('personanci')
            ->as('personanci.')
            ->group(function () {
                Route::get('', [Personanci::class, 'index']);
                Route::get('create', [Personanci::class, 'create']);
                Route::post('', [Personanci::class, 'store']);
                Route::get('{personAnci}/edit', [Personanci::class, 'edit']);

                Route::patch('{personAnci}', [Personanci::class, 'update']);

                Route::delete('{personAnci}', [Personanci::class, 'destroy']);

                Route::get('initTable', [Personanci::class, 'initTable']);
                Route::get('tableData', [Personanci::class, 'tableData']);
                Route::get('exportExcel', [Personanci::class, 'exportExcel']);

                Route::get('options', [Personanci::class, 'options']);
                Route::get('{personAnci}', [Personanci::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personasso')
            ->prefix('personasso')
            ->as('personasso.')
            ->group(function () {
                Route::get('', [Personasso::class, 'index']);
                Route::get('create', [Personasso::class, 'create']);
                Route::post('', [Personasso::class, 'store']);
                Route::get('{personAsso}/edit', [Personasso::class, 'edit']);

                Route::patch('{personAsso}', [Personasso::class, 'update']);

                Route::delete('{personAsso}', [Personasso::class, 'destroy']);

                Route::get('initTable', [Personasso::class, 'initTable']);
                Route::get('tableData', [Personasso::class, 'tableData']);
                Route::get('exportExcel', [Personasso::class, 'exportExcel']);

                Route::get('options', [Personasso::class, 'options']);
                Route::get('{personAsso}', [Personasso::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personevent')
            ->prefix('personevent')
            ->as('personevent.')
            ->group(function () {
                Route::get('', [Personevent::class, 'index']);
                Route::get('create', [Personevent::class, 'create']);
                Route::post('', [Personevent::class, 'store']);
                Route::get('{personEvent}/edit', [Personevent::class, 'edit']);

                Route::patch('{personEvent}', [Personevent::class, 'update']);

                Route::delete('{personEvent}', [Personevent::class, 'destroy']);

                Route::get('initTable', [Personevent::class, 'initTable']);
                Route::get('tableData', [Personevent::class, 'tableData']);
                Route::get('exportExcel', [Personevent::class, 'exportExcel']);

                Route::get('options', [Personevent::class, 'options']);
                Route::get('{personEvent}', [Personevent::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personlds')
            ->prefix('personlds')
            ->as('personlds.')
            ->group(function () {
                Route::get('', [Personlds::class, 'index']);
                Route::get('create', [Personlds::class, 'create']);
                Route::post('', [Personlds::class, 'store']);
                Route::get('{personLds}/edit', [Personlds::class, 'edit']);

                Route::patch('{personLds}', [Personlds::class, 'update']);

                Route::delete('{personLds}', [Personlds::class, 'destroy']);

                Route::get('initTable', [Personlds::class, 'initTable']);
                Route::get('tableData', [Personlds::class, 'tableData']);
                Route::get('exportExcel', [Personlds::class, 'exportExcel']);

                Route::get('options', [Personlds::class, 'options']);
                Route::get('{personLds}', [Personlds::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Refn')
            ->prefix('refn')
            ->as('refn.')
            ->group(function () {
                Route::get('', [Refn::class, 'index']);
                Route::get('create', [Refn::class, 'create']);
                Route::post('', [Refn::class, 'store']);
                Route::get('{refn}/edit', [Refn::class, 'edit']);

                Route::patch('{refn}', [Refn::class, 'update']);

                Route::delete('{refn}', [Refn::class, 'destroy']);

                Route::get('initTable', [Refn::class, 'initTable']);
                Route::get('tableData', [Refn::class, 'tableData']);
                Route::get('exportExcel', [Refn::class, 'exportExcel']);

                Route::get('options', [Refn::class, 'options']);
                Route::get('{refn}', [Refn::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcedata')
            ->prefix('sourcedata')
            ->as('sourcedata.')
            ->group(function () {
                Route::get('', [Sourcedata::class, 'index']);
                Route::get('create', [Sourcedata::class, 'create']);
                Route::post('', [Sourcedata::class, 'store']);
                Route::get('{sourceData}/edit', [Sourcedata::class, 'edit']);

                Route::patch('{sourceData}', [Sourcedata::class, 'update']);

                Route::delete('{sourceData}', [Sourcedata::class, 'destroy']);

                Route::get('initTable', [Sourcedata::class, 'initTable']);
                Route::get('tableData', [Sourcedata::class, 'tableData']);
                Route::get('exportExcel', [Sourcedata::class, 'exportExcel']);

                Route::get('options', [Sourcedata::class, 'options']);
                Route::get('{sourceData}', [Sourcedata::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcedataevent')
            ->prefix('sourcedataevent')
            ->as('sourcedataevent.')
            ->group(function () {
                Route::get('', [Sourcedataevent::class, 'index']);
                Route::get('create', [Sourcedataevent::class, 'create']);
                Route::post('', [Sourcedataevent::class, 'store']);
                Route::get('{sourceDataEven}/edit', [Sourcedataevent::class, 'edit']);

                Route::patch('{sourceDataEven}', [Sourcedataevent::class, 'update']);

                Route::delete('{sourceDataEven}', [Sourcedataevent::class, 'destroy']);

                Route::get('initTable', [Sourcedataevent::class, 'initTable']);
                Route::get('tableData', [Sourcedataevent::class, 'tableData']);
                Route::get('exportExcel', [Sourcedataevent::class, 'exportExcel']);

                Route::get('options', [Sourcedataevent::class, 'options']);
                Route::get('{sourceDataEven}', [Sourcedataevent::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcerefevents')
            ->prefix('sourcerefevents')
            ->as('sourcerefevents.')
            ->group(function () {
                Route::get('', [Sourcerefevents::class, 'index']);
                Route::get('create', [Sourcerefevents::class, 'create']);
                Route::post('', [Sourcerefevents::class, 'store']);
                Route::get('{sourceRefEven}/edit', [Sourcerefevents::class, 'edit']);

                Route::patch('{sourceRefEven}', [Sourcerefevents::class, 'update']);

                Route::delete('{sourceRefEven}', [Sourcerefevents::class, 'destroy']);

                Route::get('initTable', [Sourcerefevents::class, 'initTable']);
                Route::get('tableData', [Sourcerefevents::class, 'tableData']);
                Route::get('exportExcel', [Sourcerefevents::class, 'exportExcel']);

                Route::get('options', [Sourcerefevents::class, 'options']);
                Route::get('{sourceRefEven}', [Sourcerefevents::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Subm')
            ->prefix('subm')
            ->as('subm.')
            ->group(function () {
                Route::get('', [Subm::class, 'index']);
                Route::get('create', [Subm::class, 'create']);
                Route::post('', [Subm::class, 'store']);
                Route::get('{subm}/edit', [Subm::class, 'edit']);

                Route::patch('{subm}', [Subm::class, 'update']);

                Route::delete('{subm}', [Subm::class, 'destroy']);

                Route::get('initTable', [Subm::class, 'initTable']);
                Route::get('tableData', [Subm::class, 'tableData']);
                Route::get('exportExcel', [Subm::class, 'exportExcel']);

                Route::get('options', [Subm::class, 'options']);
                Route::get('{subm}', [Subm::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Subn')
            ->prefix('subn')
            ->as('subn.')
            ->group(function () {
                Route::get('', [Subn::class, 'index']);
                Route::get('create', [Subn::class, 'create']);
                Route::post('', [Subn::class, 'store']);
                Route::get('{subn}/edit', [Subn::class, 'edit']);

                Route::patch('{subn}', [Subn::class, 'update']);

                Route::delete('{subn}', [Subn::class, 'destroy']);

                Route::get('initTable', [Subn::class, 'initTable']);
                Route::get('tableData', [Subn::class, 'tableData']);
                Route::get('exportExcel', [Subn::class, 'exportExcel']);

                Route::get('options', [Subn::class, 'options']);
                Route::get('{subn}', [Subn::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personsubm')
            ->prefix('personsubm')
            ->as('personsubm.')
            ->group(function () {
                Route::get('', [PersonSubm::class, 'index']);
                Route::get('create', [PersonSubm::class, 'create']);
                Route::post('', [PersonSubm::class, 'store']);
                Route::get('{personSubm}/edit', [PersonSubm::class, 'edit']);

                Route::patch('{personSubm}', [PersonSubm::class, 'update']);

                Route::delete('{personSubm}', [PersonSubm::class, 'destroy']);

                Route::get('initTable', [PersonSubm::class, 'initTable']);
                Route::get('tableData', [PersonSubm::class, 'tableData']);
                Route::get('exportExcel', [PersonSubm::class, 'exportExcel']);

                Route::get('options', [PersonSubm::class, 'options']);
                Route::get('{personSubm}', [PersonSubm::class, 'show']);
            });
    });

Route::middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('stripe')
            ->as('stripe.')
            ->group(function () {
                Route::get('/user/setup-intent', 'StripeController@getSetupIntent');
                Route::put('/user/subscription', 'StripeController@updateSubscription');
                Route::post('/user/payments', 'StripeController@postPaymentMethods');
                Route::get('/user/payment-methods', 'StripeController@getPaymentMethods');
                Route::post('/user/remove-payment', 'StripeController@removePaymentMethod');
            });
    });

Route::middleware(['api', 'auth', 'core'])
    ->group(function () {
        Route::namespace('Trees')
            ->prefix('trees')
            ->as('trees.')
            ->group(function () {

                Route::get('', [Trees::class, 'index']);
                Route::get('create', [Trees::class, 'create']);
                Route::post('', [Trees::class, 'store']);
                Route::get('{tree}/edit', [Trees::class, 'edit']);

                Route::patch('{tree}', [Trees::class, 'update']);

                Route::delete('{tree}', [Trees::class, 'destroy']);

                Route::get('initTable', [Trees::class, 'initTable']);
                Route::get('tableData', [Trees::class, 'tableData']);
                Route::get('exportExcel', [Trees::class, 'exportExcel']);

                Route::get('options', [Trees::class, 'options']);
                Route::get('{tree}', [Trees::class, 'show']);


            });
    });

Route::middleware(['api', 'auth', 'core'])
    ->group(function () {
        Route::namespace('Dna')
            ->prefix('dna')
            ->as('dna.')
            ->group(function () {

                Route::get('', [Dna::class, 'index']);
                Route::get('create', [Dna::class, 'create']);
                Route::post('store', [Dna::class, 'store']);
                Route::get('{dna}/edit', [Dna::class, 'edit']);

                Route::patch('{dna}', [Dna::class, 'update']);

                Route::delete('{dna}', [Dna::class, 'destroy']);

                Route::get('initTable', [Dna::class, 'initTable']);
                Route::get('tableData', [Dna::class, 'tableData']);
                Route::get('exportExcel', [Dna::class, 'exportExcel']);

                Route::get('options', [Dna::class, 'options']);
                Route::get('{dna}', [Dna::class, 'show']);


            });
    });

Route::namespace('')
    ->middleware(['api', 'auth', 'core','multitenant'])
    ->prefix('api/administration/people')
    ->as('administration.people.')
    ->group(function () {
        Route::get('create', PeopleCreate::class)->name('create');
        Route::post('', PeopleStore::class)->name('store');
        Route::get('{person}/edit', PeopleEdit::class)->name('edit');
        Route::patch('{person}', PeopleUpdate::class)->name('update');
        Route::delete('{person}', PeopleDestroy::class)->name('destroy');

        Route::get('initTable', PeopleInitTable::class)->name('initTable');
        Route::get('tableData', PeopleTableData::class)->name('tableData');
        Route::get('exportExcel', PeopleExportExcel::class)->name('exportExcel');

        Route::get('options', PeopleOptions::class)->name('options');
    });

Route::namespace('')
    ->middleware(['api', 'auth', 'core','multitenant'])
    ->prefix('api/administration/companies')
    ->as('administration.companies.')
    ->group(function () {
                Route::get('create', CompanyCreate::class)->name('create');
                Route::post('', CompanyStore::class)->name('store');
                Route::get('{company}/edit', CompanyEdit::class)->name('edit');
                Route::patch('{company}', CompanyUpdate::class)->name('update');
                Route::delete('{company}', CompanyDestroy::class)->name('destroy');

                Route::get('initTable', CompanyInitTable::class)->name('initTable');
                Route::get('tableData', CompanyTableData::class)->name('tableData');
                Route::get('exportExcel', CompanyExportExcel::class)->name('exportExcel');

                Route::get('options', CompanyOptions::class)->name('options');
            });
        Route::namespace('')
            ->group(function () {
                Route::prefix('people')
                    ->as('people.')
                    ->group(function () {
                        Route::get('{company}', PeopleCompany::class)->name('index');
                        Route::get('{company}/create', PeopleCompanyCreate::class)->name('create');
                        Route::get('{company}/{person}/edit', PeopleCompanyEdit::class)->name('edit');
                        Route::patch('{person}', PeopleCompanyUpdate::class)->name('update');
                        Route::post('', PeopleCompanyStore::class)->name('store');
                        Route::delete('{company}/{person}', PeopleCompanyDestroy::class)->name('destroy');
                    });
    });

    Route::middleware(['api', 'auth', 'core'])
    ->group(function () {
        Route::namespace('Dnamatching')
            ->prefix('dnamatching')
            ->as('dnamatching.')
            ->group(function () {
                Route::get('create', [Dnamatching::class, 'create']);
                Route::get('{dnaMatching}/edit', [Dnamatching::class, 'edit']);
                Route::get('', [Dnamatching::class, 'index']);
                Route::get('initTable', [Dnamatching::class, 'initTable']);
                Route::get('tableData', [Dnamatching::class, 'tableData']);
                Route::get('{dnaMatching}', [Dnamatching::class, 'show']);
                Route::get('exportExcel', [Dnamatching::class, 'exportExcel']);
                Route::delete('{dnaMatching}', [Dnamatching::class, 'destroy']);
        });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->namespace('')
    ->prefix('api/core/calendar')
    ->as('core.calendar.')
    ->group(function (){
        Route::get('', CalendarIndex::class)->name('index');
        Route::get('create', CalendarCreate::class)->name('create');
        Route::post('', CalendarStore::class)->name('store');
        Route::get('{calendar}/edit', CalendarEdit::class)->name('edit');
        Route::patch('{calendar}', CalendarUpdate::class)->name('update');
        Route::delete('{calendar}', CalendarDestroy::class)->name('destroy');
        Route::get('options', CalendarOptions::class)->name('options');
});

Route::namespace('')
    ->prefix('events')
    ->as('events.')
    ->group(function () {
        Route::get('', EventIndex::class)->name('index');
        Route::get('create', EventCreate::class)->name('create');
        Route::post('', EventStore::class)->name('store');
        Route::get('{event}/edit', EventEdit::class)->name('edit');
        Route::patch('{event}', EventUpdate::class)->name('update');
        Route::delete('{event}', EventDestroy::class)->name('destroy');
    });

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/core/addresses')->as('core.addresses.')
    ->group(function () {
        Route::get('localities', Localities::class)->name('localities');
        Route::get('regions', Regions::class)->name('regions');
        Route::get('', AddressIndex::class)->name('index');
        Route::get('create', AddressCreate::class)->name('create');
        Route::post('', AddressStore::class)->name('store');
        Route::get('options', AddressOptions::class)->name('options');
        Route::get('postcode', Postcode::class)->name('postcode');
        Route::get('{address}/edit', AddressEdit::class)->name('edit');
        Route::get('{address}/localize', AddressLocalize::class)->name('localize');
        Route::patch('{address}', AddressUpdate::class)->name('update');
        Route::delete('{address}', AddressDestroy::class)->name('destroy');

        Route::patch('makeDefault/{address}', AddressMakeDefault::class)->name('makeDefault');
        Route::patch('makeBilling/{address}', AddressMakeBilling::class)->name('makeBilling');
        Route::patch('makeShipping/{address}', AddressMakeShipping::class)->name('makeShipping');

        Route::get('{address}', AddressShow::class)->name('show');
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->prefix('api/core/notes')->as('core.notes.')
    ->namespace('NoteCard')
    ->group(function () {
        Route::get('', [NoteCard::class, 'index']);
        Route::get('create', [NoteCard::class, 'create']);
        Route::post('', [NoteCard::class, 'store']);
        Route::get('options', [NoteCard::class, 'options']);
        Route::get('{note}/edit', [NoteCard::class, 'edit']);
        Route::patch('{note}', [NoteCard::class, 'update']);
        Route::delete('{note}', [NoteCard::class, 'destroy']);

        Route::get('{note}', [NoteCard::class, 'show']);
    });

Broadcast::routes(['middleware' => ['auth:sanctum']]);
