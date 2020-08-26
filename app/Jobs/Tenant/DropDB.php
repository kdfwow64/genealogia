<?php

namespace App\Jobs\Tenant;

use App\Service\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Multitenancy\Enums\Connections;
use LaravelEnso\Multitenancy\Traits\TenantResolver;
use Illuminate\Support\Facades\Artisan;

class DropDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TenantResolver;
    private $tenant;
    private $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $tenant, $user_id)
    {
        $this->tenant = $tenant;
        $this->user_id = $user_id;

        // $this->queue = 'light';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Tenant::set($this->tenant);

        Artisan::call('config:cache');

        $db = Connections::Tenant . $this->user_id . "_" . $this->tenant->id;

        DB::statement('DROP DATABASE ' . $db);
    }
}
