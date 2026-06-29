<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('email_change_requests')) {
            Schema::drop('email_change_requests');
        }

        if (Schema::hasColumn('users', 'profile_photo')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('profile_photo');
            });
        }

        if (Schema::hasTable('notifications')) {
            DB::table('notifications')
                ->where('data', 'like', '%permintaan-email%')
                ->orWhere('data', 'like', '%perubahan email%')
                ->delete();
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'profile_photo')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('profile_photo')->nullable()->after('email');
            });
        }

        if (! Schema::hasTable('email_change_requests')) {
            Schema::create('email_change_requests', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('old_email');
                $table->string('new_email');
                $table->string('status')->default('pending');
                $table->text('admin_note')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();
            });
        }
    }
};
