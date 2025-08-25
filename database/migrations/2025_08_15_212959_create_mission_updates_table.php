<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('mission_updates', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
    $table->decimal('lat', 10, 7)->nullable();
    $table->decimal('lng', 10, 7)->nullable();
    $table->float('battery')->nullable();  // %
    $table->float('altitude')->nullable(); // m
    $table->float('speed')->nullable();    // m/s
    $table->string('photo_path')->nullable(); // storage path
    $table->string('video_clip')->nullable(); // optional short clip
    $table->string('message')->nullable();    // free text
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
        Schema::dropIfExists('mission_updates');
    }
};
