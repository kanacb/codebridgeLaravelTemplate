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
        if (Schema::hasTable('staffinfo')) {
            dd("table staffinfo already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('staffinfo', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('empno')->nullable();
                $table->string('name');
                $table->string('namenric');
                $table->unsignedBigInteger('compcode')->nullable();
                $table->string('compname');
                $table->string('deptcode');
                $table->string('deptdesc');
                $table->unsignedBigInteger('sectcode')->nullable();
                $table->string('sectdesc');
                $table->string('designation');
                $table->string('email');
                $table->string('resign');
                $table->string('supervisor');
                $table->timestamp('datejoin')->nullable();
                $table->string('empgroup');
                $table->string('empgradecode');
                $table->string('terminationdate');
                $table->unsignedBigInteger('created_by');
                $table->foreign('created_by')->references('id')->on('users');
                $table->unsignedBigInteger('updated_by');
                $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('staffinfo');
    }
};
