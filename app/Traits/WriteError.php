<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait WriteError
{

    public function log($error, $filename)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/{$filename}.log"),
        ])->error($error);
    }
}
