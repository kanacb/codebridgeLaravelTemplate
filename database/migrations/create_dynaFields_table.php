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
        if (Schema::hasTable('dyna_fields')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('dyna_fields', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('dynaLoader');
$table->foreign('dynaLoader')->references('dynaLoader')->on('name');
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
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
