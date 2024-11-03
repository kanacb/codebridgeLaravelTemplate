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
        if (Schema::hasTable('dynaFields')) {
            dd("service");
        }
        else {
            Schema::create('dynaFields', function (Blueprint $table) {
                $table->id();
                $table->string('from');
$table->string('to2');
$table->string('toType');
$table->string('fromRefService');
$table->string('toRefService');
$table->string('fromIdentityFieldName');
$table->string('toIdentityFieldName');
$table->string('fromRelationship');
$table->string('toRelationship');
$table->boolean('duplicates');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynaFields');
    }
};
