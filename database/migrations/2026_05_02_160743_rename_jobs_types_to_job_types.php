<?php

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
        // Only rename if jobs_types table exists (for older databases)
        if (Schema::hasTable('jobs_types')) {
            Schema::rename('jobs_types', 'job_types');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only rename back if job_types exists and jobs_types doesn't
        if (Schema::hasTable('job_types') && !Schema::hasTable('jobs_types')) {
            Schema::rename('job_types', 'jobs_types');
        }
    }
};
