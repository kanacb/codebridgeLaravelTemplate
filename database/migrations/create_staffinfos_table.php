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
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('staffinfo', function (Blueprint $table) {
                $table->id();
                $table->integer('empno')->nullable();
$table->string('name');
$table->string('namenric');
$table->integer('compcode')->nullable();
$table->string('compname');
$table->string('deptcode');
$table->string('deptdesc');
$table->integer('sectcode')->nullable();
$table->string('sectdesc');
$table->string('designation');
$table->string('email');
$table->string('resign');
$table->string('supervisor');
$table->integer('datejoin')->nullable();
$table->string('empgroup');
$table->string('empgradecode');
$table->string('terminationdate');
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
