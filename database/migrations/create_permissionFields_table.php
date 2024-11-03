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
        if (Schema::hasTable('permissionFields')) {
            dd("service");
        } else {
            Schema::create('permissionFields', function (Blueprint $table) {
                $table->id();
                $table->string('service');
                $table->string('fieldId');
                $table->boolean('read')->nullable();
                $table->boolean('readAll')->nullable();
                $table->boolean('updateOwn')->nullable();
                $table->boolean('updateAll')->nullable();
                $table->boolean('deleteOwn')->nullable();
                $table->boolean('deleteAll')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissionFields');
    }
};
