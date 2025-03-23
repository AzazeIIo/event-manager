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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->string('city');
            $table->string('location');
            $table->foreignId('owner_id');
            $table->boolean('is_public');
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['name', 'date_start']);
        });

        DB::statement('ALTER TABLE events ADD CONSTRAINT chk_date_times CHECK (date_start < date_end);');
        //DB::statement('ALTER TABLE events ADD CONSTRAINT chk_start_date CHECK (NOW() < date_start);');

        DB::unprepared("CREATE TRIGGER chk_start_date
            BEFORE INSERT
            ON events
            FOR EACH ROW
            BEGIN
                IF (NOW() > NEW.date_start)
                    THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Start date must be in the future.';
                END IF;
            END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
