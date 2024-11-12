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
        if (Schema::hasTable('employees')) {
            dd("table employees already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('empNo');
                $table->string('name');
                $table->string('fullname');
                $table->unsignedBigInteger('company');
                $table->foreign('company')->references('companies')->on('name');
                $table->unsignedBigInteger('department');
                $table->foreign('department')->references('departments')->on('name');
                $table->unsignedBigInteger('section');
                $table->foreign('section')->references('sections')->on('name');
                $table->unsignedBigInteger('position');
                $table->foreign('position')->references('positions')->on('name');
                $table->unsignedBigInteger('supervisor');
                $table->foreign('supervisor')->references('employees')->on('name');
                $table->timestamp('dateJoined')->nullable();
                $table->timestamp('dateTerminated')->nullable();
                $table->string('resigned');
                $table->string('empGroup');
                $table->string('empCode');
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
        Schema::dropIfExists('employees');
    }
};
