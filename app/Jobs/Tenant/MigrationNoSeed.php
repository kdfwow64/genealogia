<?php

namespace App\Jobs\Tenant;

use App\Models\User;
use App\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Models\UserGroup;
use LaravelEnso\Multitenancy\Enums\Connections;
use App\Service\Tenant;
use LaravelEnso\Roles\Models\Role;
use Illuminate\Support\Str;

class MigrationNoSeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $c_id;
    private $u_id;
    private $name;
    private $email;
    private $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($c_id, $u_id, $name = '', $email = '')
    {
        //
        $this->c_id = $c_id;
        $this->u_id = $u_id;
        $this->name = $name;
        $this->email = $email;
        // $this->queue = 'sync';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $db = Connections::Tenant.$this->u_id."_".$this->c_id;
        $key = 'database.connections.tenant.database';
        $value = $db;
        config([$key => $value]);

        Artisan::call('migrate', [
            '--database' => Connections::Tenant,
            '--path' => '/database/migrations/tenant',
            '--force' => true,
        ]);

    }
}
