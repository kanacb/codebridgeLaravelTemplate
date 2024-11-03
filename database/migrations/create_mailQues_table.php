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
        if (Schema::hasTable('mailQues')) {
            dd("service");
        }
        else {
            Schema::create('mailQues', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->jsonb('data');
                $table->string('from')->nullable();
                $table->jsonb('recipients');
                $table->string('status')->nullable();
                $table->jsonb('errors')->nullable();
                $table->string('templateId')->nullable();
                $table->string('content')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailQues');
    }
};
