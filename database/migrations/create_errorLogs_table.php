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
        if (Schema::hasTable('errorLogs')) {
            dd("service");
        } else {
            Schema::create('errorLogs', function (Blueprint $table) {
                $table->id();
                $table->string('serviceName')->nullable();
                $table->string('errorMessage')->nullable();
                $table->string('message')->nullable();
                $table->string('stack')->nullable();
                $table->string('details')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('errorLogs');
    }
};
