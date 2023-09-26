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
        Schema::table('~cb-app-migration-servicename~', function (Blueprint $table) {
            ~cb-app-migration-field-up~
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ~cb-app-migration-field-down~
    }
}`;
