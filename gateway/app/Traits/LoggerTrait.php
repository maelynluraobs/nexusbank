<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LoggerTrait
{
    public function logInfo($message)
    {
        Log::info($message);
    }

    public function logError($message)
    {
        Log::error($message);
    }
}
