<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_services', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // REG, EXP, TRK, SEA, AIR, CORP
            $table->string('name', 100);
            $table->enum('transport_type', ['DARAT', 'UDARA', 'LAUT'])->default('DARAT');
            $table->text('description')->nullable();
            $table->decimal('min_weight', 8, 2)->default(1.00);
            $table->string('estimated_time', 50)->nullable(); // e.g. "2-3 Hari"
            $table->string('icon', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->nullable()->unique();
            $table->string('name', 150);
            $table->string('pic_name', 100)->nullable();
            $table->string('phone', 30);
            $table->string('whatsapp', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('province')->nullable();
            $table->string('regency')->nullable();
            $table->text('address')->nullable();
            $table->enum('customer_type', ['REGULAR', 'CORPORATE'])->default('REGULAR');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('name');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('shipping_services');
    }
};
