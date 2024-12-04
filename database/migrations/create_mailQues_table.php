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
        if (Schema::hasTable('mail_ques')) {
            dd("service");
        } else {
            Schema::create('mail_ques', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('data')->nullable();
                $table->string('from')->nullable();
                $table->string('recipients')->nullable();
                $table->string('status');
                $table->string('subject');
                $table->string('errors')->nullable();
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
        Schema::dropIfExists('mail_ques');
    }
};