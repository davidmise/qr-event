<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{   /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('text_overlays', function (Blueprint $table) {
            $table->id();
            $table->string('identifier'); // Identifier for the image or template
            $table->integer('x');
            $table->integer('y');
            $table->integer('font_size');
            $table->string('font_family');
            $table->string('font_color');
            $table->string('template')->nullable(); // Template image path
            $table->timestamps();
        });
    }


   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
       Schema::dropIfExists('text_overlays');
   }
};
