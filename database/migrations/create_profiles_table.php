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
        if (Schema::hasTable('profiles')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
$table->unsignedBigInteger('userId');
$table->foreign('userId')->references('users')->on('name');
$table->string('image');
$table->text('bio')->nullable();
$table->unsignedBigInteger('department');
$table->foreign('department')->references('departments')->on('name');
$table->boolean('hod');
$table->unsignedBigInteger('section');
$table->foreign('section')->references('sections')->on('name');
$table->boolean('hos');
$table->unsignedBigInteger('position');
$table->foreign('position')->references('positions')->on('name');
$table->unsignedBigInteger('manager');
$table->foreign('manager')->references('users')->on('name');
$table->unsignedBigInteger('company');
$table->foreign('company')->references('companies')->on('name');
$table->unsignedBigInteger('branch');
$table->foreign('branch')->references('branches')->on('name');
$table->string('skills');
$table->unsignedBigInteger('address');
$table->foreign('address')->references('userAddresses')->on('Street1');
$table->unsignedBigInteger('phone');
$table->foreign('phone')->references('userPhones')->on('number');
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
        Schema::dropIfExists('profiles');
    }
};
