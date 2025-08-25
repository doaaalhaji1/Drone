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
      Schema::create('missions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('disaster_report_id')->constrained()->cascadeOnDelete();
    $table->foreignId('assigned_by')->constrained('users'); // admin
    $table->enum('status', ['assigned','launched','streaming','returning','completed','failed'])->default('assigned');
    $table->string('stream_url')->nullable(); // RTMP/RTSP/WebRTC link
    $table->timestamp('started_at')->nullable();
    $table->timestamp('ended_at')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->index(['status']);
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
};
