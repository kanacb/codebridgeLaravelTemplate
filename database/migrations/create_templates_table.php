<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('templates')) {
            dd("table templates already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('templates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('subject')->nullable();
                $table->text('body')->nullable();
                $table->string('image');
                $table->timestamps();
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
