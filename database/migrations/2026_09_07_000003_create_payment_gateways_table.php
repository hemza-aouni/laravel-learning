<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Stripe, PayPal, LemonSqueezy, Offline
            $table->string('slug')->unique();                // stripe, paypal, lemonsqueezy, offline
            $table->string('type')->default('online');       // online | offline
            $table->string('public_key')->nullable();
            $table->text('secret_key')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->string('mode')->default('sandbox');      // sandbox | live
            $table->boolean('is_active')->default(false);
            $table->string('official_url')->nullable();
            $table->json('extra_settings')->nullable();      // لأي إعدادات إضافية
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
