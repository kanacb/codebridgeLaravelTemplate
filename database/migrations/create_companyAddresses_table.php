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
        if (Schema::hasTable('company_addresses')) {
            dd("table company_addresses already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('company_addresses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('companyId');
                $table->foreign('companyId')->references('companies')->on('name');
                $table->text('Street1')->nullable();
                $table->text('Street2')->nullable();
                $table->string('Poscode');
                $table->string('City');
                $table->string('State');
                $table->string('Province');
                $table->string('Country');
                $table->boolean('isDefault')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->foreign('created_by')->references('id')->on('users');
                $table->unsignedBigInteger('updated_by');
                $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('companyAddresses');
    }
};