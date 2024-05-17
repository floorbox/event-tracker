<?php

namespace EventTracker\Actions\TrackableEvent;

use EventTracker\Models\TrackableEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTrackableEvent
{
    use AsAction;

    public function handle(string $eventName, int $userId, array $metadata, ?string $trackedModelName = null, ?int $trackedModelId = null, ?int $value = null): void
    {
        TrackableEvent::create([
            'event_name' => $eventName,
            'user_id' => $userId,
            'metadata' => $metadata,
            'tracked_model_type' => $trackedModelName,
            'tracked_model_id' => $trackedModelId,
            'value' => $value
        ]);
    }
}
