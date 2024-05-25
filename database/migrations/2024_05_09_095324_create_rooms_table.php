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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lookuproom_id')->nullable();
            $table->string('room_number')->unique();
            $table->integer('room_count');
            $table->float('price'); 
            $table->text('description')->nullable();
            $table->string('room_size');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('lookuproom_id')->references('id')->on('lookup_rooms')->onDelete('set null');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
