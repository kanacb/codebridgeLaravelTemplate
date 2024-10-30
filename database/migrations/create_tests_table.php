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
        if (Schema::hasTable('tests')) {
            dd("service");
        }
        else {
            Schema::create('tests', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('stack');

$table->string('service');

$table->string('notes');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
