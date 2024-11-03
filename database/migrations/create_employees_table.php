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
                $table->string('empNo')->nullable();
$table->string('name')->nullable();
$table->string('fullname')->nullable();
$table->string('resigned')->nullable();
$table->string('empGroup')->nullable();
$table->string('empCode')->nullable();
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
