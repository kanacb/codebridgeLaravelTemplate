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
        if (Schema::hasTable('user_guide_steps')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('user_guide_steps', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userGuideID');
$table->foreign('userGuideID')->references('userGuides')->on('serviceName');
$table->date('steps')->nullable();
$table->string('description');
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
        Schema::dropIfExists('userGuideSteps');
    }
};
