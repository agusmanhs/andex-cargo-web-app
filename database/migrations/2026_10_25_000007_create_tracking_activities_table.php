<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->foreignId('manifest_id')->nullable()->constrained('manifests')->nullOnDelete();
            $table->string('status', 50);
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('location', 100)->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('happened_at');
            $table->timestamps();

            $table->index(['shipment_id', 'happened_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_activities');
    }
};
