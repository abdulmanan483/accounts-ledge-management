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
        Schema::table('users', function (Blueprint $table) {
            $table->string(column: 'email')->nullable()->default('')->change();
            // $table->dropUnique(['email']); // Remove the unique constraint
            // $table->dropIfExists('users_email_unique');
            $table->string('password')->nullable()->default('')->change();
            $table->dateTime('registration_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('gender')->nullable()->default(1)->comment('1 for male, 0 for female');
            $table->string('profile_picture')->nullable()->default('');
            $table->string('cnic')->nullable()->default('');
            $table->string('mobile_no')->nullable()->default('');
            $table->string('cnic_front')->nullable()->default('');
            $table->string('cnic_back')->nullable()->default('');
            $table->string('current_city')->nullable()->default('');
            $table->string('current_country')->nullable()->default('');
            $table->text('educational_qualifications')->nullable();
            $table->text('skills')->nullable();
            $table->tinyInteger('data_source')->nullable()->default(1)->comment('1 for google form, 2 for web form');

            $table->string('external_profile_pic')->after('profile_picture')->nullable();
            $table->string('external_cnic_front')->after('cnic_front')->nullable();
            $table->string('external_cnic_back')->after('cnic_back')->nullable();

            $table->integer('user_type')->default(0)->after('password');

            $table->integer('form_no')->nullable()->default(0);
            $table->boolean('is_pakistani')->default(1)->comment('1 for Pakistani, 0 for overseas');

            $table->boolean('is_approved')->default(0);
            $table->boolean('is_added')->default(0);

            $table->string('status')->default(1)->comment('1 for Pending Approval, 2 for Approved, 3 for Rejected, 4 for Removed');
            $table->text('comments')->nullable();
            // Optional: Add an index to the status column for performance
            $table->index('status');

            $table->unsignedInteger('current_country_id')->nullable()->after('current_country');
            $table->unsignedInteger('current_city_id')->nullable()->after('current_city');
            $table->text('current_address')->nullable()->after('current_city_id');
            $table->unsignedInteger('permanent_country_id')->nullable()->after('current_address');
            $table->unsignedInteger('permanent_city_id')->nullable()->after('permanent_country_id');
            $table->text('permanent_address')->nullable()->after('permanent_city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'current_country_id',
                'current_city_id',
                'current_address',
                'permanent_country_id',
                'permanent_city_id',
                'permanent_address',
                'status',
                'comments',
                'is_approved',
                'is_added',
                'form_no',
                'is_pakistani',
                'user_type',
                'external_profile_pic',
                'external_cnic_front',
                'external_cnic_back',
                'registration_date',
                'gender',
                'profile_picture',
                'cnic',
                'mobile_no',
                'cnic_front',
                'cnic_back',
                'current_city',
                'current_country',
                'educational_qualifications',
                'skills',
                'data_source'
            ]);
        });
    }
};
