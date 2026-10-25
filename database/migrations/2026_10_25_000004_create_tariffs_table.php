<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('shipping_services')->nullOnDelete();
            $table->string('from_regency', 100);
            $table->string('to_regency', 100);
            $table->decimal('price_per_kg', 12, 2)->default(0);
            $table->decimal('min_weight', 12, 2)->default(10.00);
            $table->decimal('min_price', 12, 2)->default(0);
            $table->string('estimated_time', 50)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['from_regency', 'to_regency']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
