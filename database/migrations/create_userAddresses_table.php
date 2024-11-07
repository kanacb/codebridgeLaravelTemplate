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
        if (Schema::hasTable('user_addresses')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
$table->foreign('userId')->references('users')->on('name');
$table->text('Street1')->nullable();
$table->text('Street2')->nullable();
$table->string('Poscode');
$table->string('City');
$table->string('State');
$table->string('Province');
$table->string('Country');
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
        Schema::dropIfExists('userAddresses');
    }
};
