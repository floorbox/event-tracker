<?php

namespace EventTracker\Actions\TrackableEvent\Listeners;

use EventTracker\Actions\TrackableEvent\CreateTrackableEvent;
use EventTracker\Events\TrackableEventEncountered;
use Lorisleiva\Actions\Concerns\AsAction;

class LogTrackableEvent
{
    use AsAction;

    public function handle(TrackableEventEncountered $event): void
    {
        CreateTrackableEvent::run(
            $event->eventName,
            $event->userId,
            $event->metadata,
            $event->trackedModelName,
            $event->trackedModelId,
            $event->value
        );
    }
}
