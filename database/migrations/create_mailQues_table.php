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
                $table->string("_id");
                $table->string('name');

$table->string('type');

$table->string('data');

$table->string('from');

$table->string('recipients');

$table->string('status');

$table->string('errors');

$table->string('template');

$table->string('content');

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
