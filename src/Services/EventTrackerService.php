<?php

namespace EventTracker\Services;

use EventTracker\Actions\TrackableEvent\CreateTrackableEvent;
use EventTracker\Enums\TrackableEvents;
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

    public function send(mixed $trackableEvent, ?int $value = null): void
    {
        $eventTitle = $trackableEvent instanceof TrackableEvents ? $trackableEvent->value : $trackableEvent;

        $userId = $this->getActingUser();

        if (!$userId) {
            // For now, if the event sent is anonymous, we just bail
            return;
        }

        CreateTrackableEvent::dispatch(
            $eventTitle,
            $userId,
            $this->metadata,
            $this->trackedModelName,
            $this->trackedModelId,
            $value
        );
    }

    private function getActingUser(): ?int
    {
        $actingUserId = auth()->id();

        if ($actingUserId) {
            return $actingUserId;
        }

        foreach (array_keys((array) config('auth.guards', [])) as $guardName) {
            try {
                $guardUserId = auth($guardName)->id();
            } catch (\Throwable $e) {
                report($e);
                continue;
            }

            if ($guardUserId) {
                return $guardUserId;
            }
        }

        return null;
    }

}
