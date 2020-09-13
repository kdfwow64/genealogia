<?php

namespace App\Console\Commands;

use App\Jobs\Tenant\Migration;
use App\Models\User;
use Illuminate\Console\Command;
use LaravelEnso\Multitenancy\Enums\Connections;

class RunTenantsMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genealogia:tenant:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run All Tenants Migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role_id', '!=', 1)->get();

        foreach ($users as $user) {
            $person = $user->person;
            $companies = $person->companies;
            foreach ($companies as $company) {
                if ($company !== null) {
                    $this->setConnection(Connections::Tenant, $company->id, $user->id);
                }
                $name = $user->email . ' - ' . $person->name;
                Migration::dispatch($company->id, $user->id, $name, $user->email);
            }
        }

    }
}
