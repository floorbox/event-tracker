<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('trackable_events')) {
            return;
        }

        Schema::create('trackable_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->json('metadata');
            $table->nullableMorphs('tracked_model');
            $table->integer('value')->nullable();
            $table->timestamps();

            $table->index(['event_name'], 'event_index');
            $table->index(['event_name', 'created_at'], 'event_time_index');
            $table->index(['event_name', 'user_id', 'created_at'], 'event_user_time_index');
        });
    }
};
