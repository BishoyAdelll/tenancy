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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->string('number');
            $table->time('time');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->enum('status',[
                \App\Enums\Status::Confirmed->value,
                \App\Enums\Status::Booked->value,
                \App\Enums\Status::Cancelled->value,
            ])->default(\App\Enums\Status::Booked->value);
            $table->string('hall')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
