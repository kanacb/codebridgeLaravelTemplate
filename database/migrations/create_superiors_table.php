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
        if (Schema::hasTable('superior')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('superior', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('superior');
$table->foreign('superior')->references('staffinfo')->on('supervisor');
$table->unsignedBigInteger('subordinate');
$table->foreign('subordinate')->references('staffinfo')->on('empno');
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
        Schema::dropIfExists('superior');
    }
};
