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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->text('qr_code')->nullable();
            $table->unsignedBigInteger('guest_attendance_id')->nullable();
            $table->foreign('guest_attendance_id')->references('id')->on('guest_attendances')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('event_info_id')->nullable();
            $table->foreign('event_info_id')->references('id')->on('event_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
