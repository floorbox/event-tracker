<?php

namespace EventTracker\Facades;

use EventTracker\Services\EventTrackerService;
use Illuminate\Support\Facades\Facade;

class EventTracker extends Facade
{
    protected static $instance;

    protected static function getFacadeAccessor()
    {
        return EventTrackerService::class;
    }
}
