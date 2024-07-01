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

        Schema::table('card_image_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('event_info_id')->nullable();
            $table->foreign('event_info_id')->references('id')->on('event_infos')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_image_templates', function (Blueprint $table) {
            $table->dropColumn('event_info_id');
        });
    }
};
