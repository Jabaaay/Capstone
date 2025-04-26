<?php

namespace App\Listeners;

use App\Events\TestSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleTestSubmission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TestSubmitted $event): void
    {
        // Handle the test submission event
        // This is where you can add any additional logic
        // that needs to happen when a test is submitted
    }
} 