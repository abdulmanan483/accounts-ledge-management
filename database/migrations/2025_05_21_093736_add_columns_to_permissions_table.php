<?php

use App\Enums\Permissions\PermissionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('guard_name');
            $table->string('group')->default('all')->after('display_name');
            $table->string('display_group')->default('All')->after('group');
            $table->string('type')->default(PermissionType::ADMIN_PANEL)->after('display_group');
            $table->string('display_type')->default(PermissionType::ADMIN_PANEL->label())->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['display_name','group','display_group','type','display_type']);
        });
    }
};
