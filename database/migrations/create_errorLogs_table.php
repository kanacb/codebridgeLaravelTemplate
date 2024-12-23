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
        if (Schema::hasTable('error_logs')) {
            dd("table error_logs already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('error_logs', function (Blueprint $table) {
                $table->id();
                $table->string('serviceName');
                $table->string('errorMessage');
                $table->string('message');
                $table->string('stack');
                $table->string('details');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->foreign('created_by')->references('id')->on('users');
                $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('errorLogs');
    }
};
