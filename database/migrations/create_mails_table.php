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
        if (Schema::hasTable('mails')) {
            dd("service");
        }
        else {
            Schema::create('mails', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('status');

$table->string('subject');

$table->string('body');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mails');
    }
};
