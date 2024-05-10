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
        Schema::create('guest_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('created_on')->nullable();
            $table->date('data_expires')->nullable();
            $table->enum('status', ['Attended', 'Registered']);
            $table->unsignedBigInteger('event_info_id')->nullable();
            $table->foreign('event_info_id')->references('id')->on('event_infos');
            //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_attendances');
    }
};
