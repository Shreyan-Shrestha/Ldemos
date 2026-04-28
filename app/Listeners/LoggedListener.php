<?php

namespace App\Listeners;

use App\Events\LoggedEvent;
use App\Jobs\DemoBackupJob;
use App\Services\DemoLogger;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoggedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public DemoLogger $demoLogger)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedEvent $event): void
    {
        $demodata = $event->demodata;
        $this->demoLogger->log("Listener dispatches data backup to Job for " . $demodata->name);
        dispatch(new DemoBackupJob($demodata));
    }
}
