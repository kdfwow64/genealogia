<?php

namespace App\Jobs;

use App\Dna;
use App\DnaMatching as DM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DnaMatching implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $var_name, $file_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($var_name, $file_name)
    {
        $this->var_name = $var_name;
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dnas = Dna::where('variable_name', '!=', $this->var_name)->get();
        foreach ($dnas as $dna) {
            exec('python dna.py ' . $this->var_name . ' ' . $dna->variable_name . ' ' . $this->file_name . ' ' . $dna->file_name);
            $dm = new DM();
            $dm->image = 'shared_dna_'.$this->var_name.'_'.$dna->variable_name.'.png';
            $dm->file1 = 'shared_dna_one_chrom_'.$this->var_name.'_'.$dna->variable_name.'_GRCh37.csv';
            $dm->file2 = 'shared_dna_'.$this->var_name.'_'.$dna->variable_name.'_GRCh37.csv';
            $dm->save();
        }
    }
}
