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
            dd("table document_storages already exists");
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::create('document_storages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('size')->nullable();
                $table->text('path');
                $table->timestamp('lastModifiedDate')->nullable();
                $table->timestamp('lastModified')->nullable();
                $table->string('eTag');
                $table->text('url');
                $table->string('tableId');
                $table->string('tableName');
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
        Schema::dropIfExists('documentStorages');
    }
};
