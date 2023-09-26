module.exports = `<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('~cb-app-migration-servicename~', function (Blueprint $table) {
            $table->id();
            ~cb-app-migration-field-up~
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('~cb-app-migration-field-down~');
    }
}`;
