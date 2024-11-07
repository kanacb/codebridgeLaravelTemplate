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
        if (Schema::hasTable('document_storages')) {
            dd("service");
        }
        else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('document_storages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
$table->integer('size')->nullable();
$table->text('path');
$table->date('lastModifiedDate')->nullable();
$table->date('lastModified')->nullable();
$table->string('eTag');
$table->text('url');
$table->string('tableId');
$table->string('tableName');
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
        Schema::dropIfExists('documentStorages');
    }
};
