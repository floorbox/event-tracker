<?php

namespace EventTracker\Services;

use CBOX\Framework\Enums\TrackableEvent;
use CBOX\Framework\Events\TrackableEventEncountered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class EventTrackerService
{
    protected ?string $trackedModelName = null;
    protected ?int $trackedModelId = null;
    protected array $metadata = [];

    public function attachMetadata(array $metadata): EventTrackerService
    {
        if (empty($metadata)) {
            throw ValidationException::withMessages(['The metadata must be an array and must not be empty']);
        }

        $this->metadata = $metadata;

        return $this;
    }

    public function attachModel(Model $trackedModel): EventTrackerService
    {
        $this->trackedModelName = (new \ReflectionClass($trackedModel))->getShortName() . 'Model';
        $this->trackedModelId = $trackedModel->id;

        return $this;
    }

    public function send(TrackableEvent $trackableEvent, ?int $value = null): void
    {
        if (!$trackableEvent->value) {
            throw ValidationException::withMessages(['Invalid event name']);
        }

        $userId = $this->getActingUser();

        if(!$userId)
        {
            // For now, if the event sent is anonymous, we just bail
            return;
        }

        event(new TrackableEventEncountered($trackableEvent->value, $userId, $this->metadata, $this->trackedModelName, $this->trackedModelId, $value));
    }

    private function getActingUser()
    {
        $actingUserId = auth()->id();

        if (!$actingUserId) {
            $actingUserId = auth()->user()?->id ?? null;
        }

        if (!$actingUserId) {
            $actingUserId = auth('web')->user()?->id ?? null;
        }

        if (!$actingUserId) {
            $actingUserId = auth('api')->user()?->id ?? null;
        }

        return $actingUserId;
    }

}
