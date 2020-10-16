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

use App\Http\Controllers\Sources\Create as SourcesCreate;
use App\Http\Controllers\Sources\Destroy as SourcesDestroy;
use App\Http\Controllers\Sources\Edit as SourcesEdit;
use App\Http\Controllers\Sources\ExportExcel as SourcesExportExcel;
use App\Http\Controllers\Sources\InitTable as SourcesInitTable;
use App\Http\Controllers\Sources\Options as SourcesOptions;
use App\Http\Controllers\Sources\Store as SourcesStore;
use App\Http\Controllers\Sources\TableData as SourcesTableData;
use App\Http\Controllers\Sources\Update as SourcesUpdate;

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
        Route::namespace('')
            ->prefix('citations')
            ->as('citations.')
            ->group(function () {
                Route::get('', [CitationsIndex::class, 'index']);
                Route::get('create', [CitationsCreate::class, 'create']);
                Route::post('', [CitationsStore::class, 'create']);
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
                Route::get('', [FamiliesIndex::class, 'index']);
                Route::get('create', [FamiliesCreate::class, 'create']);
                Route::post('', [FamiliesStore::class, 'create']);
                Route::get('{family}/edit', [FamiliesEdit::class, 'edit']);

                Route::patch('{family}', [FamiliesUpdate::class, 'update']);

                Route::delete('{family}', [FamiliesDestroy::class, 'destroy']);

                Route::get('initTable', [FamiliesInitTable::class, 'initTable']);
                Route::get('tableData', [FamiliesTableData::class, 'tableData']);
                Route::get('exportExcel', [FamiliesExportExcel::class, 'exportExcel']);

                Route::get('options', [FamiliesOptions::class, 'options']);
                Route::get('{family}', [FamiliesShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Notes')
            ->prefix('notes')
            ->as('notes.')
            ->group(function () {
                Route::get('', [NoteIndex::class, 'index']);
                Route::get('create', [NoteCreate::class, 'create']);
                Route::post('', [NoteStore::class, 'create']);
                Route::get('{note}/edit', [NoteEdit::class, 'edit']);

                Route::patch('{note}', [NoteUpdate::class, 'update']);

                Route::delete('{note}', [NoteDestroy::class, 'destroy']);

                Route::get('initTable', [NoteInitTable::class, 'initTable']);
                Route::get('tableData', [NoteTableData::class, 'tableData']);
                Route::get('exportExcel', [NoteExportExcel::class, 'exportExcel']);

                Route::get('options', [NoteOptions::class, 'options']);
                Route::get('{note}', [NoteShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Places')
            ->prefix('places')
            ->as('places.')
            ->group(function () {
                Route::get('', [PlaceIndex::class, 'index']);
                Route::get('create', [PlaceCreate::class, 'create']);
                Route::post('', [PlaceStore::class, 'create']);
                Route::get('{place}/edit', [PlaceEdit::class, 'edit']);

                Route::patch('{place}', [PlaceUpdate::class, 'update']);

                Route::delete('{place}', [PlaceDestroy::class, 'destroy']);

                Route::get('initTable', [PlaceInitTable::class, 'initTable']);
                Route::get('tableData', [PlaceTableData::class, 'tableData']);
                Route::get('exportExcel', [PlaceExportExcel::class, 'exportExcel']);

                Route::get('options', [PlaceOptions::class, 'options']);
                Route::get('{place}', [PlaceShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Repositories')
            ->prefix('repositories')
            ->as('repositories.')
            ->group(function () {
                Route::get('', [RepostioriesIndex::class, 'index']);
                Route::get('create', [RepostioriesCreate::class, 'create']);
                Route::post('', [RepostioriesStore::class, 'create']);
                Route::get('{repository}/edit', [RepostioriesEdit::class, 'edit']);

                Route::patch('{repository}', [RepostioriesUpdate::class, 'update']);

                Route::delete('{repository}', [RepostioriesDestroy::class, 'destroy']);

                Route::get('initTable', [RepostioriesInitTable::class, 'initTable']);
                Route::get('tableData', [RepostioriesTableData::class, 'tableData']);
                Route::get('exportExcel', [RepostioriesExportExcel::class, 'exportExcel']);

                Route::get('options', [RepostioriesOptions::class, 'options']);
                Route::get('{repository}', [RepostioriesShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sources')
            ->prefix('sources')
            ->as('sources.')
            ->group(function () {
                Route::get('', [SourcesIndex::class, 'index']);
                Route::get('create', [SourcesCreate::class, 'create']);
                Route::post('', [SourcesStore::class, 'create']);
                Route::get('{source}/edit', [SourcesEdit::class, 'edit']);

                Route::patch('{source}', [SourcesUpdate::class, 'update']);

                Route::delete('{source}', [SourcesDestroy::class, 'destroy']);

                Route::get('initTable', [SourcesInitTable::class, 'initTable']);
                Route::get('tableData', [SourcesTableData::class, 'tableData']);
                Route::get('exportExcel', [SourcesExportExcel::class, 'exportExcel']);

                Route::get('options', [SourcesOptions::class, 'options']);
                Route::get('{source}', [SourcesShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Types')
            ->prefix('types')
            ->as('types.')
            ->group(function () {
                Route::get('', [TypesIndex::class, 'index']);
                Route::get('create', [TypesCreate::class, 'create']);
                Route::post('', [TypesStore::class, 'create']);
                Route::get('{type}/edit', [TypesEdit::class, 'edit']);

                Route::patch('{type}', [TypesUpdate::class, 'update']);

                Route::delete('{type}', [TypesDestroy::class, 'destroy']);

                Route::get('initTable', [TypesInitTable::class, 'initTable']);
                Route::get('tableData', [TypesTableData::class, 'tableData']);
                Route::get('exportExcel', [TypesExportExcel::class, 'exportExcel']);

                Route::get('options', [TypesOptions::class, 'options']);
                Route::get('{type}', [TypesShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Authors')
            ->prefix('authors')
            ->as('authors.')
            ->group(function () {
                Route::get('', [AuthorsIndex::class, 'index']);
                Route::get('create', [AuthorsCreate::class, 'create']);
                Route::post('', [AuthorsStore::class, 'create']);
                Route::get('{author}/edit', [AuthorsEdit::class, 'edit']);

                Route::patch('{author}', [AuthorsUpdate::class, 'update']);

                Route::delete('{author}', [AuthorsDestroy::class, 'destroy']);

                Route::get('initTable', [AuthorsInitTable::class, 'initTable']);
                Route::get('tableData', [AuthorsTableData::class, 'tableData']);
                Route::get('exportExcel', [AuthorsExportExcel::class, 'exportExcel']);

                Route::get('options', [AuthorsOptions::class, 'options']);
                Route::get('{author}', [AuthorsShow::class, 'show']);
            });
    });
Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Publications')
            ->prefix('publications')
            ->as('publications.')
            ->group(function () {
                Route::get('', [PublicationsIndex::class, 'index']);
                Route::get('create', [PublicationsCreate::class, 'create']);
                Route::post('', [PublicationsStore::class, 'create']);
                Route::get('{publication}/edit', [PublicationsEdit::class, 'edit']);

                Route::patch('{publication}', [PublicationsUpdate::class, 'update']);

                Route::delete('{publication}', [PublicationsDestroy::class, 'destroy']);

                Route::get('initTable', [PublicationsInitTable::class, 'initTable']);
                Route::get('tableData', [PublicationsTableData::class, 'tableData']);
                Route::get('exportExcel', [PublicationsExportExcel::class, 'exportExcel']);

                Route::get('options', [PublicationsOptions::class, 'options']);
                Route::get('{publication}', [PublicationsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Gedcom')
            ->prefix('gedcom')
            ->as('gedcom.')
            ->group(function () {
                Route::post('store', [GedcomStore::class, 'create']);
            });
    });

Route::get('gedcom/progress', '\App\Http\Controllers\Gedcom\Progress@index')->name('progress');

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('MediaObjects')
            ->prefix('mediaobjects')
            ->as('mediaobjects.')
            ->group(function () {
                Route::get('', [MediaObjectsIndex::class, 'index']);
                Route::get('create', [MediaObjectsCreate::class, 'create']);
                Route::post('', [MediaObjectsStore::class, 'create']);
                Route::get('{mediaobjects}/edit', [MediaObjectsEdit::class, 'edit']);

                Route::patch('{mediaobjects}', [MediaObjectsUpdate::class, 'update']);

                Route::delete('{mediaobjects}', [MediaObjectsDestroy::class, 'destroy']);

                Route::get('initTable', [MediaObjectsInitTable::class, 'initTable']);
                Route::get('tableData', [MediaObjectsTableData::class, 'tableData']);
                Route::get('exportExcel', [MediaObjectsExportExcel::class, 'exportExcel']);

                Route::get('options', [MediaObjectsOptions::class, 'options']);
                Route::get('{mediaobject}', [MediaObjectsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Addrs')
            ->prefix('addrs')
            ->as('addrs.')
            ->group(function () {
                Route::get('', [AddrsIndex::class, 'index']);
                Route::get('create', [AddrsCreate::class, 'create']);
                Route::post('', [AddrsStore::class, 'create']);
                Route::get('{addr}/edit', [AddrsEdit::class, 'edit']);

                Route::patch('{addr}', [AddrsUpdate::class, 'update']);

                Route::delete('{addr}', [AddrsDestroy::class, 'destroy']);

                Route::get('initTable', [AddrsInitTable::class, 'initTable']);
                Route::get('tableData', [AddrsTableData::class, 'tableData']);
                Route::get('exportExcel', [AddrsExportExcel::class, 'exportExcel']);

                Route::get('options', [AddrsOptions::class, 'options']);
                Route::get('{addr}', [AddrsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Chan')
            ->prefix('chan')
            ->as('chan.')
            ->group(function () {
                Route::get('', [ChanIndex::class, 'index']);
                Route::get('create', [ChanCreate::class, 'create']);
                Route::post('', [ChanStore::class, 'create']);
                Route::get('{chan}/edit', [ChanEdit::class, 'edit']);

                Route::patch('{chan}', [ChanUpdate::class, 'update']);

                Route::delete('{chan}', [ChanDestroy::class, 'destroy']);

                Route::get('initTable', [ChanInitTable::class, 'initTable']);
                Route::get('tableData', [ChanTableData::class, 'tableData']);
                Route::get('exportExcel', [ChanExportExcel::class, 'exportExcel']);

                Route::get('options', [ChanOptions::class, 'options']);
                Route::get('{chan}', [ChanShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Familyevents')
            ->prefix('familyevents')
            ->as('familyevents.')
            ->group(function () {
                Route::get('', [FamilyeventsIndex::class, 'index']);
                Route::get('create', [FamilyeventsCreate::class, 'create']);
                Route::post('', [FamilyeventsStore::class, 'create']);
                Route::get('{familyEvent}/edit', [FamilyeventsEdit::class, 'edit']);

                Route::patch('{familyEvent}', [FamilyeventsUpdate::class, 'update']);

                Route::delete('{familyEvent}', [FamilyeventsDestroy::class, 'destroy']);

                Route::get('initTable', [FamilyeventsInitTable::class, 'initTable']);
                Route::get('tableData', [FamilyeventsTableData::class, 'tableData']);
                Route::get('exportExcel', [FamilyeventsExportExcel::class, 'exportExcel']);

                Route::get('options', [FamilyeventsOptions::class, 'options']);
                Route::get('{familyEvent}', [FamilyeventsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Familyslugs')
            ->prefix('familyslugs')
            ->as('familyslugs.')
            ->group(function () {
                Route::get('', [FamilyslugsIndex::class, 'index']);
                Route::get('create', [FamilyslugsCreate::class, 'create']);
                Route::post('', [FamilyslugsStore::class, 'create']);
                Route::get('{familySlgs}/edit', [FamilyslugsEdit::class, 'edit']);

                Route::patch('{familySlgs}', [FamilyslugsUpdate::class, 'update']);

                Route::delete('{familySlgs}', [FamilyslugsDestroy::class, 'destroy']);

                Route::get('initTable', [FamilyslugsInitTable::class, 'initTable']);
                Route::get('tableData', [FamilyslugsTableData::class, 'tableData']);
                Route::get('exportExcel', [FamilyslugsExportExcel::class, 'exportExcel']);

                Route::get('options', [FamilyslugsOptions::class, 'options']);
                Route::get('{familySlgs}', [FamiliesslugsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personalias')
            ->prefix('personalias')
            ->as('personalias.')
            ->group(function () {
                Route::get('', [PersonaliasIndex::class, 'index']);
                Route::get('create', [PersonaliasCreate::class, 'create']);
                Route::post('', [PersonaliasStore::class, 'create']);
                Route::get('{personAlia}/edit', [PersonaliasEdit::class, 'edit']);

                Route::patch('{personAlia}', [PersonaliasUpdate::class, 'update']);

                Route::delete('{personAlia}', [PersonaliasDestroy::class, 'destroy']);

                Route::get('initTable', [PersonaliasInitTable::class, 'initTable']);
                Route::get('tableData', [PersonaliasTableData::class, 'tableData']);
                Route::get('exportExcel', [PersonaliasExportExcel::class, 'exportExcel']);

                Route::get('options', [PersonaliasOptions::class, 'options']);
                Route::get('{personAlia}', [PersonaliasShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personanci')
            ->prefix('personanci')
            ->as('personanci.')
            ->group(function () {
                Route::get('', [PersonanciIndex::class, 'index']);
                Route::get('create', [PersonanciCreate::class, 'create']);
                Route::post('', [PersonanciStore::class, 'create']);
                Route::get('{personAnci}/edit', [PersonanciEdit::class, 'edit']);

                Route::patch('{personAnci}', [PersonanciUpdate::class, 'update']);

                Route::delete('{personAnci}', [PersonanciDestroy::class, 'destroy']);

                Route::get('initTable', [PersonanciInitTable::class, 'initTable']);
                Route::get('tableData', [PersonanciTableData::class, 'tableData']);
                Route::get('exportExcel', [PersonanciExportExcel::class, 'exportExcel']);

                Route::get('options', [PersonanciOptions::class, 'options']);
                Route::get('{personAnci}', [PersonanciShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personasso')
            ->prefix('personasso')
            ->as('personasso.')
            ->group(function () {
                Route::get('', [PersonassoIndex::class, 'index']);
                Route::get('create', [PersonassoCreate::class, 'create']);
                Route::post('', [PersonassoStore::class, 'create']);
                Route::get('{personAsso}/edit', [PersonassoEdit::class, 'edit']);

                Route::patch('{personAsso}', [PersonassoUpdate::class, 'update']);

                Route::delete('{personAsso}', [PersonassoDestroy::class, 'destroy']);

                Route::get('initTable', [PersonassoInitTable::class, 'initTable']);
                Route::get('tableData', [PersonassoTableData::class, 'tableData']);
                Route::get('exportExcel', [PersonassoExportExcel::class, 'exportExcel']);

                Route::get('options', [PersonassoOptions::class, 'options']);
                Route::get('{personAsso}', [PersonassoShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personevent')
            ->prefix('personevent')
            ->as('personevent.')
            ->group(function () {
                Route::get('', [PersoneventIndex::class, 'index']);
                Route::get('create', [PersoneventCreate::class, 'create']);
                Route::post('', [PersoneventStore::class, 'create']);
                Route::get('{personEvent}/edit', [PersoneventEdit::class, 'edit']);

                Route::patch('{personEvent}', [PersoneventUpdate::class, 'update']);

                Route::delete('{personEvent}', [PersoneventDestroy::class, 'destroy']);

                Route::get('initTable', [PersoneventInitTable::class, 'initTable']);
                Route::get('tableData', [PersoneventTableData::class, 'tableData']);
                Route::get('exportExcel', [PersoneventExportExcel::class, 'exportExcel']);

                Route::get('options', [PersoneventOptions::class, 'options']);
                Route::get('{personEvent}', [PersoneventShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personlds')
            ->prefix('personlds')
            ->as('personlds.')
            ->group(function () {
                Route::get('', [PersonldsIndex::class, 'index']);
                Route::get('create', [PersonldsCreate::class, 'create']);
                Route::post('', [PersonldsStore::class, 'create']);
                Route::get('{personLds}/edit', [PersonldsEdit::class, 'edit']);

                Route::patch('{personLds}', [PersonldsUpdate::class, 'update']);

                Route::delete('{personLds}', [PersonldsDestroy::class, 'destroy']);

                Route::get('initTable', [PersonldsInitTable::class, 'initTable']);
                Route::get('tableData', [PersonldsTableData::class, 'tableData']);
                Route::get('exportExcel', [PersonldsExportExcel::class, 'exportExcel']);

                Route::get('options', [PersonldsOptions::class, 'options']);
                Route::get('{personLds}', [PersonldsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Refn')
            ->prefix('refn')
            ->as('refn.')
            ->group(function () {
                Route::get('', [RefnIndex::class, 'index']);
                Route::get('create', [RefnCreate::class, 'create']);
                Route::post('', [RefnStore::class, 'create']);
                Route::get('{refn}/edit', [RefnEdit::class, 'edit']);

                Route::patch('{refn}', [RefnUpdate::class, 'update']);

                Route::delete('{refn}', [RefnDestroy::class, 'destroy']);

                Route::get('initTable', [RefnInitTable::class, 'initTable']);
                Route::get('tableData', [RefnTableData::class, 'tableData']);
                Route::get('exportExcel', [RefnExportExcel::class, 'exportExcel']);

                Route::get('options', [RefnOptions::class, 'options']);
                Route::get('{refn}', [RefnShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcedata')
            ->prefix('sourcedata')
            ->as('sourcedata.')
            ->group(function () {
                Route::get('', [SourcedataIndex::class, 'index']);
                Route::get('create', [SourcedataCreate::class, 'create']);
                Route::post('', [SourcedataStore::class, 'create']);
                Route::get('{sourceData}/edit', [SourcedataEdit::class, 'edit']);

                Route::patch('{sourceData}', [SourcedataUpdate::class, 'update']);

                Route::delete('{sourceData}', [SourcedataDestroy::class, 'destroy']);

                Route::get('initTable', [SourcedataInitTable::class, 'initTable']);
                Route::get('tableData', [SourcedataTableData::class, 'tableData']);
                Route::get('exportExcel', [SourcedataExportExcel::class, 'exportExcel']);

                Route::get('options', [SourcedataOptions::class, 'options']);
                Route::get('{sourceData}', [SourcedataShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcedataevent')
            ->prefix('sourcedataevent')
            ->as('sourcedataevent.')
            ->group(function () {
                Route::get('', [SourcedataeventIndex::class, 'index']);
                Route::get('create', [SourcedataeventCreate::class, 'create']);
                Route::post('', [SourcedataeventStore::class, 'create']);
                Route::get('{sourceDataEven}/edit', [SourcedataeventEdit::class, 'edit']);

                Route::patch('{sourceDataEven}', [SourcedataeventUpdate::class, 'update']);

                Route::delete('{sourceDataEven}', [SourcedataeventDestroy::class, 'destroy']);

                Route::get('initTable', [SourcedataeventInitTable::class, 'initTable']);
                Route::get('tableData', [SourcedataeventTableData::class, 'tableData']);
                Route::get('exportExcel', [SourcedataeventExportExcel::class, 'exportExcel']);

                Route::get('options', [SourcedataeventOptions::class, 'options']);
                Route::get('{sourceDataEven}', [SourcedataeventShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Sourcerefevents')
            ->prefix('sourcerefevents')
            ->as('sourcerefevents.')
            ->group(function () {
                Route::get('', [SourcerefeventsIndex::class, 'index']);
                Route::get('create', [SourcerefeventsCreate::class, 'create']);
                Route::post('', [SourcerefeventsStore::class, 'create']);
                Route::get('{sourceRefEven}/edit', [SourcerefeventsEdit::class, 'edit']);

                Route::patch('{sourceRefEven}', [SourcerefeventsUpdate::class, 'update']);

                Route::delete('{sourceRefEven}', [SourcerefeventsDestroy::class, 'destroy']);

                Route::get('initTable', [SourcerefeventsInitTable::class, 'initTable']);
                Route::get('tableData', [SourcerefeventsTableData::class, 'tableData']);
                Route::get('exportExcel', [SourcerefeventsExportExcel::class, 'exportExcel']);

                Route::get('options', [SourcerefeventsOptions::class, 'options']);
                Route::get('{sourceRefEven}', [SourcerefeventsShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Subm')
            ->prefix('subm')
            ->as('subm.')
            ->group(function () {
                Route::get('', [SubmIndex::class, 'index']);
                Route::get('create', [SubmCreate::class, 'create']);
                Route::post('', [SubmStore::class, 'create']);
                Route::get('{subm}/edit', [SubmEdit::class, 'edit']);

                Route::patch('{subm}', [SubmUpdate::class, 'update']);

                Route::delete('{subm}', [SubmDestroy::class, 'destroy']);

                Route::get('initTable', [SubmInitTable::class, 'initTable']);
                Route::get('tableData', [SubmTableData::class, 'tableData']);
                Route::get('exportExcel', [SubmExportExcel::class, 'exportExcel']);

                Route::get('options', [SubmOptions::class, 'options']);
                Route::get('{subm}', [SubmShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Subn')
            ->prefix('subn')
            ->as('subn.')
            ->group(function () {
                Route::get('', [SubnIndex::class, 'index']);
                Route::get('create', [SubnCreate::class, 'create']);
                Route::post('', [SubnStore::class, 'create']);
                Route::get('{subn}/edit', [SubnEdit::class, 'edit']);

                Route::patch('{subn}', [SubnUpdate::class, 'update']);

                Route::delete('{subn}', [SubnDestroy::class, 'destroy']);

                Route::get('initTable', [SubnInitTable::class, 'initTable']);
                Route::get('tableData', [SubnTableData::class, 'tableData']);
                Route::get('exportExcel', [SubnExportExcel::class, 'exportExcel']);

                Route::get('options', [SubnOptions::class, 'options']);
                Route::get('{subn}', [SubnShow::class, 'show']);
            });
    });

Route::middleware(['api', 'auth', 'core', 'multitenant'])
    ->group(function () {
        Route::namespace('Personsubm')
            ->prefix('personsubm')
            ->as('personsubm.')
            ->group(function () {
                Route::get('', [PersonSubmIndex::class, 'index']);
                Route::get('create', [PersonSubmCreate::class, 'create']);
                Route::post('', [PersonSubmStore::class, 'create']);
                Route::get('{personSubm}/edit', [PersonSubmEdit::class, 'edit']);

                Route::patch('{personSubm}', [PersonSubmUpdate::class, 'update']);

                Route::delete('{personSubm}', [PersonSubmDestroy::class, 'destroy']);

                Route::get('initTable', [PersonSubmInitTable::class, 'initTable']);
                Route::get('tableData', [PersonSubmTableData::class, 'tableData']);
                Route::get('exportExcel', [PersonSubmExportExcel::class, 'exportExcel']);

                Route::get('options', [PersonSubmOptions::class, 'options']);
                Route::get('{personSubm}', [PersonSubmShow::class, 'show']);
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

                Route::get('', [TreesIndex::class, 'index']);
                Route::get('create', [TreesCreate::class, 'create']);
                Route::post('', [TreesStore::class, 'create']);
                Route::get('{tree}/edit', [TreesEdit::class, 'edit']);

                Route::patch('{tree}', [TreesUpdate::class, 'update']);

                Route::delete('{tree}', [TreesDestroy::class, 'destroy']);

                Route::get('initTable', [TreesInitTable::class, 'initTable']);
                Route::get('tableData', [TreesTableData::class, 'tableData']);
                Route::get('exportExcel', [TreesExportExcel::class, 'exportExcel']);

                Route::get('options', [TreesOptions::class, 'options']);
                Route::get('{tree}', [TreesShow::class, 'show']);


            });
    });

Route::middleware(['api', 'auth', 'core'])
    ->group(function () {
        Route::namespace('Dna')
            ->prefix('dna')
            ->as('dna.')
            ->group(function () {

                Route::get('', [DnaIndex::class, 'index']);
                Route::get('create', [DnaCreate::class, 'create']);
                Route::post('store', [DnaStore::class, 'create']);
                Route::get('{dna}/edit', [DnaEdit::class, 'edit']);

                Route::patch('{dna}', [DnaUpdate::class, 'update']);

                Route::delete('{dna}', [DnaDestroy::class, 'destroy']);

                Route::get('initTable', [DnaInitTable::class, 'initTable']);
                Route::get('tableData', [DnaTableData::class, 'tableData']);
                Route::get('exportExcel', [DnaExportExcel::class, 'exportExcel']);

                Route::get('options', [DnaOptions::class, 'options']);
                Route::get('{dna}', [DnaShow::class, 'show']);


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
                Route::get('create', [DnamatchingCreate::class, 'create']);
                Route::get('{dnaMatching}/edit', [DnamatchingEdit::class, 'edit']);
                Route::get('', [DnamatchingIndex::class, 'index']);
                Route::get('initTable', [DnamatchingInitTable::class, 'initTable']);
                Route::get('tableData', [DnamatchingTableData::class, 'tableData']);
                Route::get('{dnaMatching}', [DnamatchingShow::class, 'show']);
                Route::get('exportExcel', [DnamatchingExportExcel::class, 'exportExcel']);
                Route::delete('{dnaMatching}', [DnamatchingDestroy::class, 'destroy']);
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
        Route::get('', [NoteCardIndex::class, 'index']);
        Route::get('create', [NoteCardCreate::class, 'create']);
        Route::post('', [NoteCardStore::class, 'create']);
        Route::get('options', [NoteCardOptions::class, 'options']);
        Route::get('{note}/edit', [NoteCardEdit::class, 'edit']);
        Route::patch('{note}', [NoteCardUpdate::class, 'update']);
        Route::delete('{note}', [NoteCardDestroy::class, 'destroy']);

        Route::get('{note}', [NoteCardShow::class, 'show']);
    });

Broadcast::routes(['middleware' => ['auth:sanctum']]);
