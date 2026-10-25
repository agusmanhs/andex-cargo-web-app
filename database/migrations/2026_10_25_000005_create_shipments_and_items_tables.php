<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 50)->unique();
            $table->foreignId('origin_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('destination_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('shipping_services')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Sender info
            $table->string('sender_name', 100);
            $table->string('sender_phone', 30);
            $table->text('sender_address')->nullable();
            $table->string('origin_city', 100);

            // Receiver info
            $table->string('receiver_name', 100);
            $table->string('receiver_phone', 30);
            $table->text('receiver_address')->nullable();
            $table->string('destination_city', 100);

            // Metrics
            $table->integer('total_colly')->default(1);
            $table->decimal('actual_weight', 8, 2)->default(0);
            $table->decimal('volume_weight', 8, 2)->default(0);
            $table->decimal('chargeable_weight', 8, 2)->default(0);

            // Pricing & Payment
            $table->decimal('tariff_per_kg', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('packing_cost', 12, 2)->default(0);
            $table->decimal('insurance_cost', 12, 2)->default(0);
            $table->decimal('other_cost', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->enum('payment_type', ['CASH', 'COD', 'INVOICE'])->default('CASH');
            $table->enum('payment_status', ['UNPAID', 'PAID'])->default('UNPAID');

            // Status & Tracking
            $table->enum('status', [
                'CREATED',
                'PICKED_UP',
                'ORIGIN_HUB',
                'MANIFESTED',
                'IN_TRANSIT',
                'DESTINATION_HUB',
                'OUT_FOR_DELIVERY',
                'DELIVERED',
                'RETURNED',
                'CANCELLED'
            ])->default('ORIGIN_HUB');
            $table->boolean('is_manifested')->default(false);
            $table->string('current_location', 100)->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('recipient_name', 100)->nullable();
            $table->text('pod_notes')->nullable();
            $table->string('pod_photo', 255)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tracking_number');
            $table->index('status');
            $table->index('is_manifested');
            $table->index(['origin_branch_id', 'status']);
        });

        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->string('item_name', 150)->nullable();
            $table->integer('colly_count')->default(1);
            $table->decimal('length_cm', 8, 2)->default(0);
            $table->decimal('width_cm', 8, 2)->default(0);
            $table->decimal('height_cm', 8, 2)->default(0);
            $table->decimal('actual_weight_kg', 8, 2)->default(0);
            $table->decimal('volume_weight_kg', 8, 2)->default(0);
            $table->decimal('chargeable_weight_kg', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
        Schema::dropIfExists('shipments');
    }
};
