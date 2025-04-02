<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('event_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unique(['user_id', 'event_id']);
            $table->timestamps();
        });

        DB::unprepared("CREATE TRIGGER public_events_dont_need_invitations
            BEFORE INSERT
            ON invitations
            FOR EACH ROW
            BEGIN
                IF (SELECT is_public FROM events WHERE id = NEW.event_id)
                    THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Public events are visible to everyone.';
                END IF;
            END;");

        DB::unprepared("CREATE TRIGGER kick_uninvited_attendees
            AFTER DELETE
            ON invitations
            FOR EACH ROW
            BEGIN
                DELETE FROM attendees WHERE user_id = old.user_id;
            END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
