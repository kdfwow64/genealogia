<?php

namespace App\Jobs\Tenant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\enso\companies\Company;
use LaravelEnso\Multitenancy\Enums\Connections;

class CreateDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $company_id;
    private $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($c_id, $u_id)
    {
        //
        $this->company_id = $c_id;
        $this->user_id = $u_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dbname = Connections::Tenant.$this->user_id.'_'.$this->company_id;
        DB::statement('CREATE DATABASE '.$dbname);
    }
}
