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
        if (Schema::hasTable('inbox')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('inbox', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('from');
$table->foreign('from')->references('users')->on('name');
$table->unsignedBigInteger('toUser');
$table->foreign('toUser')->references('users')->on('name');
$table->string('content');
$table->boolean('read')->nullable();
$table->date('sent')->nullable();
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
        Schema::dropIfExists('inbox');
    }
};
