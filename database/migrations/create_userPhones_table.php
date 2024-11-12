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
        if (Schema::hasTable('user_phones')) {
            dd("table user_phones already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('user_phones', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
                $table->foreign('userId')->references('users')->on('name');
                $table->unsignedBigInteger('countryCode')->nullable();
                $table->unsignedBigInteger('operatorCode')->nullable();
                $table->unsignedBigInteger('number')->nullable();
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
        Schema::dropIfExists('userPhones');
    }
};
