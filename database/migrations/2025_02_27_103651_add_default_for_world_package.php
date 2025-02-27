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
        $citiesTable    = config('world.migrations.cities.table_name', 'cities');
        $optionalFields = config('world.migrations.cities.optional_fields', []);

        if (Schema::hasTable($citiesTable)) {
            Schema::table($citiesTable, function (Blueprint $table) use ($optionalFields) {
                foreach ($optionalFields as $field => $options) {
                    // Only modify the column if it exists, don't add new columns
                    if (Schema::hasColumn($table->getTable(), $field)) {
                        $type     = $options['type'] ?? 'string';
                        $length   = $options['length'] ?? null;
                        $required = $options['required'] ?? false;

                        // Modify existing column
                        if ($field == 'data_source') {
                            $table->string($field, $length ?? 255)->default('package')->change();
                        } else {

                            if ($type === 'string') {
                                $column = $table->string($field, $length ?? 255)->nullable()->change();
                            } elseif ($type === 'integer') {
                                $column = $table->integer($field)->nullable()->change();
                            } elseif ($type === 'boolean') {
                                $column = $table->boolean($field)->nullable()->change();
                            } elseif ($type === 'float' || $type === 'double') {
                                $column = $table->double($field)->nullable()->change();
                            } else {
                                continue; // Skip unknown types
                            }
                        }

                        // // Apply nullable() only if required is false
                        // if (!$required) {
                        //     $column->nullable()->change();
                        // }
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $citiesTable    = config('world.migrations.cities.table_name', 'cities');
        $optionalFields = config('world.migrations.cities.optional_fields', []);

        if (Schema::hasTable($citiesTable)) {
            Schema::table($citiesTable, function (Blueprint $table) use ($optionalFields) {
                foreach ($optionalFields as $field => $options) {
                    if (Schema::hasColumn($table->getTable(), $field)) {
                        $type   = $options['type'] ?? 'string';
                        $length = $options['length'] ?? null;

                        // Revert column to non-nullable
                        if ($type === 'string') {
                            $table->string($field, $length ?? 255)->nullable(false)->change();
                        } elseif ($type === 'integer') {
                            $table->integer($field)->nullable(false)->change();
                        } elseif ($type === 'boolean') {
                            $table->boolean($field)->nullable(false)->change();
                        } elseif ($type === 'float' || $type === 'double') {
                            $table->double($field)->nullable(false)->change();
                        }
                        // Remove the default value for 'data_source' column
                        if ($field === 'data_source') {
                            $table->string($field)->default(null)->change();
                        }
                    }
                }
            });
        }
    }
};
