<?php

use EventTracker\EventTrackerServiceProvider;
use EventTracker\Services\EventTrackerService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

it('boots its provider and resolves its service on Laravel 13', function () {
    expect(app()->getProvider(EventTrackerServiceProvider::class))
        ->toBeInstanceOf(EventTrackerServiceProvider::class)
        ->and(app(EventTrackerService::class))->toBeInstanceOf(EventTrackerService::class);
});

it('loads and runs its package migration on Laravel 13', function () {
    Schema::create('users', function (Blueprint $table): void {
        $table->id();
    });

    expect(Artisan::call('migrate', ['--force' => true]))->toBe(0)
        ->and(Schema::hasTable('trackable_events'))->toBeTrue();
});
