<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'hotel_name')) {
                $table->string('hotel_name')->nullable();
            }
            if (!Schema::hasColumn('tenants', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('tenants', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('tenants', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable();
            }
            if (!Schema::hasColumn('tenants', 'subscription_status')) {
                $table->string('subscription_status')->default('trial');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['hotel_name', 'email', 'password', 'trial_ends_at', 'subscription_status']);
        });
    }
};
