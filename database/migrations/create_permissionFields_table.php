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
        if (Schema::hasTable('permissionFields')) {
            dd("service");
        }
        else {
            Schema::create('permissionFields', function (Blueprint $table) {
                $table->id();
                $table->string("_id");
                $table->string('service');

$table->string('fieldId');

                $table->timestamps();
            });
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
