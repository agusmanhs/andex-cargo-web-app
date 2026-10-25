<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 60)->nullable()->unique()->after('name');
            $table->string('phone', 30)->nullable()->after('email');
            $table->enum('role', [
                'SUPERADMIN',     // BOD / Direksi (full access)
                'BRANCH_MANAGER', // Supervisor / Kepala Cabang
                'OPERATOR',       // CS / Admin kasir input resi
                'COURIER',        // Driver / Kurir
                'CUSTOMER'        // B2B Corporate Client
            ])->default('OPERATOR')->after('password');
            $table->foreignId('branch_id')->nullable()->after('role')->constrained('branches')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['username', 'phone', 'role', 'branch_id', 'is_active']);
        });
    }
};
