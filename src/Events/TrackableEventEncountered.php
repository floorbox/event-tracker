<?php

namespace EventTracker\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TrackableEventEncountered
{
    use Dispatchable, SerializesModels;
    public string $eventName;
    public int $userId;
    public ?string $trackedModelName;
    public ?string $trackedModelId;
    public array $metadata;
    public ?int $value;

    public function __construct(string $eventName, int $userId, array $metadata, ?string $trackedModelName = null, ?int $trackedModelId, ?int $value = null)
    {
        $this->eventName = $eventName;
        $this->userId = $userId;
        $this->metadata = $metadata;
        $this->trackedModelName = $trackedModelName;
        $this->trackedModelId = $trackedModelId;
        $this->value = $value;
    }
}
