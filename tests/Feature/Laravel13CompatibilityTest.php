<?php

use EventTracker\Services\EventTrackerService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

it('boots its provider and resolves its service on Laravel 13', function () {
    expect(app(EventTrackerService::class))->toBeInstanceOf(EventTrackerService::class);
});

it('loads and runs its package migration on Laravel 13', function () {
    Artisan::call('migrate', ['--force' => true]);

    expect(Schema::hasTable('trackable_events'))->toBeTrue();
});
