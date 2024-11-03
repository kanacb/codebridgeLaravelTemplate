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
        if (Schema::hasTable('userPhones')) {
            dd("service");
        }
        else {
            Schema::create('userPhones', function (Blueprint $table) {
                $table->id();
                $table->integer('countryCode')->nullable();
$table->integer('operatorCode')->nullable();
$table->integer('number')->nullable();
$table->boolean('isDefault')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userPhones');
    }
};
