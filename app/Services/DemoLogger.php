<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class DemoLogger
{

    public function log($message)
    {
        Log::info("From logger: " . $message);
        return $message. " logged successfully";
    }
}
