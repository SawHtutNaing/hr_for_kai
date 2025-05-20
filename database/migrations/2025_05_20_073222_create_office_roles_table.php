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
        Schema::create('office_roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('payscale_id');
            $table->timestamps();
            $table->foreign('payscale_id')->references('id')->on('payscales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_roles');
    }
};
