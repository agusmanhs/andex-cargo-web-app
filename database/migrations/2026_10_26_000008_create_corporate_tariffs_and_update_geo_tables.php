<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tabel dinamai dalam bahasa Indonesia standar: provinsi & kabupaten
        if (Schema::hasTable('provinces') && !Schema::hasTable('provinsi')) {
            Schema::rename('provinces', 'provinsi');
        }

        if (Schema::hasTable('regencies') && !Schema::hasTable('kabupaten')) {
            Schema::rename('regencies', 'kabupaten');
        }

        // Buat tabel Tarif Kontrak Khusus Corporate / B2B
        if (!Schema::hasTable('corporate_tariffs')) {
            Schema::create('corporate_tariffs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
                $table->foreignId('service_id')->nullable()->constrained('shipping_services')->nullOnDelete();
                $table->string('from_kabupaten', 50);
                $table->string('to_kabupaten', 50);
                $table->string('contract_number', 100)->nullable();
                $table->decimal('price_per_kg', 12, 2)->default(0);
                $table->decimal('min_weight', 12, 2)->default(10.00);
                $table->decimal('min_price', 12, 2)->default(0);
                $table->string('estimated_time', 50)->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['customer_id', 'from_kabupaten', 'to_kabupaten']);
                $table->index('is_active');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_tariffs');
    }
};
