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
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'status'], 'idx_users_role_status');
            $table->index(['username', 'role'], 'idx_users_username_role');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'idx_attendances_user_date');
            $table->index(['date', 'status'], 'idx_attendances_date_status');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'idx_journals_user_date');
            $table->index(['date', 'status'], 'idx_journals_date_status');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_leaves_user_status');
            $table->index(['status', 'created_at'], 'idx_leaves_status_created');
        });

        Schema::table('alumni_stories', function (Blueprint $table) {
            $table->index(['is_visible', 'order'], 'idx_alumni_visible_order');
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->index(['is_visible', 'category', 'order'], 'idx_gallery_visible_cat_order');
        });

        Schema::table('procedures', function (Blueprint $table) {
            $table->index(['is_visible', 'step_number'], 'idx_procedures_visible_step');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            $table->dropIndex('idx_procedures_visible_step');
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropIndex('idx_gallery_visible_cat_order');
        });

        Schema::table('alumni_stories', function (Blueprint $table) {
            $table->dropIndex('idx_alumni_visible_order');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex('idx_leaves_status_created');
            $table->dropIndex('idx_leaves_user_status');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->dropIndex('idx_journals_date_status');
            $table->dropIndex('idx_journals_user_date');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('idx_attendances_date_status');
            $table->dropIndex('idx_attendances_user_date');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_username_role');
            $table->dropIndex('idx_users_role_status');
        });
    }
};
