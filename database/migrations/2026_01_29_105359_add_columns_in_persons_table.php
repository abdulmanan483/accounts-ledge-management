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
        Schema::table('persons', function (Blueprint $table) {
            $table->decimal('current_balance', 15, 2)->default(0)->after('type');
            $table->decimal('total_debit', 15, 2)->default(0)->after('current_balance');
            $table->decimal('total_credit', 15, 2)->default(0)->after('total_debit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('current_balance');
            $table->dropColumn('total_debit');
            $table->dropColumn('total_credit');
        });
    }
};
