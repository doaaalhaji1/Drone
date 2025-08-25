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
        Schema::create('disaster_reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->enum('type', ['fire','flood','earthquake','other']);
    $table->enum('severity', ['low','medium','high'])->default('low');
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->decimal('lat', 10, 7);
    $table->decimal('lng', 10, 7);
    $table->string('address')->nullable();
    $table->enum('status', ['pending','approved','rejected','in_progress','completed','failed'])->default('pending');
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
        Schema::dropIfExists('disaster_reports');
    }
};
