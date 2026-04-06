<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Moved to an earlier timestamp so foreign-key dependent migrations
        // always run in the correct order on fresh installs.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
