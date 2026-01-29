<?php

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
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('name');
            $table->string('account_title')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_title');
            $table->string('iban')->nullable()->after('account_number');
            $table->string('branch_name')->nullable()->after('iban');
            $table->string('branch_code')->nullable()->after('branch_name');
            $table->string('swift_code')->nullable()->after('branch_code');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('account_title');
            $table->dropColumn('account_number');
            $table->dropColumn('iban');
            $table->dropColumn('branch_name');
            $table->dropColumn('branch_code');
            $table->dropColumn('swift_code');
        });
    }
};
