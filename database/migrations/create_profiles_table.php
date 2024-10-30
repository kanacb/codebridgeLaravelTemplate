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
        if (Schema::hasTable('profiles')) {
            dd("service");
        }
        else {
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('name');

$table->string('image');

$table->string('bio');

$table->string('skills');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
