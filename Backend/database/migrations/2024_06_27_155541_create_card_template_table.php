<?php
// database/migrations/2024_06_27_155541_create_card_templates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('card_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('event_info_id')->nullable();
            $table->foreign('event_info_id')->references('id')->on('event_infos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_templates');
    }
};
