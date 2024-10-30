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
        if (Schema::hasTable('employees')) {
            dd("service");
        }
        else {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('empNo');

$table->string('name');

$table->string('fullname');

$table->string('resigned');

$table->string('empGroup');

$table->string('empCode');

                $table->timestamps();
            });
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
