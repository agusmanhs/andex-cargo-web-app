<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manifests', function (Blueprint $table) {
            $table->id();
            $table->string('manifest_number', 50)->unique();
            $table->foreignId('origin_branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('destination_branch_id')->constrained('branches')->cascadeOnDelete();
            $table->enum('transport_type', ['TRUCK', 'KAPAL', 'PESAWAT', 'VAN'])->default('TRUCK');
            $table->string('vehicle_plate_number', 30)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('driver_phone', 30)->nullable();
            $table->string('vendor_name', 100)->nullable();
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('estimated_arrival')->nullable();
            $table->dateTime('arrived_at')->nullable();
            $table->enum('status', [
                'DRAFT',
                'LOADING',
                'DEPARTED',
                'IN_TRANSIT',
                'ARRIVED',
                'CLOSED'
            ])->default('DRAFT');
            $table->integer('total_shipments')->default(0);
            $table->integer('total_colly')->default(0);
            $table->decimal('total_weight', 10, 2)->default(0);
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('manifest_number');
            $table->index('status');
            $table->index(['origin_branch_id', 'destination_branch_id']);
        });

        Schema::create('manifest_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manifest_id')->constrained('manifests')->cascadeOnDelete();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->enum('status', ['LOADED', 'RECEIVED', 'SHORTAGE', 'DAMAGED'])->default('LOADED');
            $table->dateTime('scanned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['manifest_id', 'shipment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manifest_items');
        Schema::dropIfExists('manifests');
    }
};
