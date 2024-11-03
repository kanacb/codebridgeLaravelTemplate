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
        if (Schema::hasTable('documentStorage')) {
            dd("service");
        } else {
            Schema::create('documentStorage', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->integer('size')->nullable();
                $table->text('path');
                $table->string('eTag')->nullable();
                $table->text('url');
                $table->string('tableId')->nullable();
                $table->string('tableName')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentStorage');
    }
};
