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
        if (Schema::hasTable('company_phones')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('company_phones', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('companyId');
$table->foreign('companyId')->references('companies')->on('name');
$table->integer('countryCode')->nullable();
$table->integer('operatorCode')->nullable();
$table->integer('number')->nullable();
$table->boolean('isDefault')->nullable();
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
        Schema::dropIfExists('companyPhones');
    }
};
