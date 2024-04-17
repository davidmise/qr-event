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
        Schema::table('guests', function (Blueprint $table) {
            //
             // Foreign key for ticketing (assuming one-to-one relationship)
             $table->unsignedBigInteger('guest_attendance_id')->nullable();
             $table->foreign('guest_attendance_id')->references('id')->on('guest_attendances')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */

};
