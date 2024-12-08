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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique();
            $table->string('man_name')->nullable();
            $table->integer('man_phone')->nullable();
            $table->string('women_name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('man_id')->nullable(); //edit
            $table->string('women_phone')->nullable();
            $table->unsignedBigInteger('women_id')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->foreignId('hall_id')->references('id')->on('Halls')->onDelete('cascade');
            $table->decimal('hall_price',10,3);
            $table->decimal('discount_halls',10,3);
            $table->string('the_numbers_of_hours');
            $table->decimal('photography',10,3)->default(0);
            $table->dateTime('confirmedDate')->nullable();
            $table->enum('Payment',[
                \App\Enums\Payment::Cash->value,
                \App\Enums\Payment::Visa->value,
                \App\Enums\Payment::InstaPay->value,
            ]);
            $table->enum('status',[
                \App\Enums\Status::Confirmed->value,
                \App\Enums\Status::Booked->value,
                \App\Enums\Status::Cancelled->value,
            ]);
            $table->decimal('insurance',10,3)->nullable();
//            $table->string('discount');
//            $table->string('tax');
            $table->decimal('grand_total',10,2);
            $table->string('paid');
            $table->decimal('total_price',10,3);
            $table->tinyInteger('is_edited')->default(0);
            $table->json('dates')->nullable();
            $table->string('hall')->nullable();
            $table->string('fines')->nullable();
            $table->decimal('hall_rival',10,3)->default(0)->nullable();
            $table->decimal('residual',10,3)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
