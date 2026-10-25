<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->id();
            $table->string('province_code', 10);
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->timestamps();

            $table->index('province_code');
            $table->index('name');
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // e.g. UPG, JKT, SUB
            $table->string('name', 100);
            $table->enum('type', ['HUB', 'BRANCH', 'AGENT'])->default('BRANCH');
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('province_id')->nullable();
            $table->string('regency_id')->nullable();
            $table->text('address')->nullable();
            $table->text('header_address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
    }
};
