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
        if (Schema::hasTable('templates')) {
            dd("service");
        }
        else {
            Schema::create('templates', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('name');

$table->string('subject');

$table->string('body');

$table->string('variables');

$table->string('image');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
