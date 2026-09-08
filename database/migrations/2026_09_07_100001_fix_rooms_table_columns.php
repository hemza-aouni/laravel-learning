<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إذا الجدول غير موجود → إنشاؤه بالكامل
        if (!Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->string('tenant_id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->string('currency', 10)->default('USD');
                $table->integer('capacity')->default(2);
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                $table->index('tenant_id');
            });
            return;
        }

        // الجدول موجود → نضيف الأعمدة الناقصة فقط
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'tenant_id')) {
                $table->string('tenant_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('rooms', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('rooms', 'currency')) {
                $table->string('currency', 10)->default('USD');
            }
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->integer('capacity')->default(2);
            }
            if (!Schema::hasColumn('rooms', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('rooms', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    public function down(): void
    {
        // لا نحذف شيئاً للسلامة
    }
};
