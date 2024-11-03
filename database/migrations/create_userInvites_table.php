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
        if (Schema::hasTable('userInvites')) {
            dd("service");
        } else {
            Schema::create('userInvites', function (Blueprint $table) {
                $table->id();
                $table->string('emailToInvite')->nullable();
                $table->boolean('status')->nullable();
                $table->integer('code')->nullable();
                $table->integer('sendMailCounter')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userInvites');
    }
};
