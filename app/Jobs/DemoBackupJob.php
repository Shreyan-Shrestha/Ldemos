<?php

namespace App\Jobs;

use App\Models\demobackup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class DemoBackupJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $demodata;
    public function __construct($demodata)
    {
        $this->demodata = $demodata;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
            sleep(2);
            demobackup::create([
            'name' => $this->demodata->name,
            'description' => $this->demodata->description,
        ]);
            Log::info('Demo backup Job completed.');
    }
}
