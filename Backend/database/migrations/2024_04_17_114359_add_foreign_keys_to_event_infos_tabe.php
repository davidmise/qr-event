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
        Schema::table('event_infos', function (Blueprint $table) {
            //
            // Foreign key for organizer (assuming one-to-one relationship)
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('cascade')->onUpdate('cascade');

            // Foreign key for social links (assuming one-to-one relationship)
            $table->unsignedBigInteger('social_links_id')->nullable();
            $table->foreign('social_links_id')->references('id')->on('social_links')->onDelete('cascade')->onUpdate('cascade');

            // Foreign key for ticketing (assuming one-to-one relationship)
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
};
