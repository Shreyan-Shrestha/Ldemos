<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class DemoLogger
{

    public function log(string $message) : string
    {
        Log::info("From logger: " . $message);
        return $message. " logged successfully";
    }
}
