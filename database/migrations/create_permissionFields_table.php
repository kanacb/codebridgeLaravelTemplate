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
        if (Schema::hasTable('permission_fields')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('permission_fields', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('profile');
$table->foreign('profile')->references('profiles')->on('name');
$table->string('service');
$table->string('fieldId');
$table->boolean('read')->nullable();
$table->boolean('readAll')->nullable();
$table->boolean('updateOwn')->nullable();
$table->boolean('updateAll')->nullable();
$table->boolean('deleteOwn')->nullable();
$table->boolean('deleteAll')->nullable();
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
        Schema::dropIfExists('permissionFields');
    }
};
