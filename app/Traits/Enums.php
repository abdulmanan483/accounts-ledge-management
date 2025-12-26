<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Enums
{
    /**
     * Get all enum values
     *
     * @return array
     */
    public static function values(): array
    {
        // PHP 8.1+ native enums support `cases()`
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Get all enum labels (case names)
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }

    /**
     * Get all enum options as [label => value]
     *
     * @return array
     */
    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }

    /**
     * Get the enum case name from a value
     *
     * @param mixed $value
     * @return string|null
     */
    public static function labelFromValue(mixed $value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return Str::title($case->name);
            }
        }

        return null;
    }

    /**
     * Get array of objects with value and name pairs
     *
     * @return array<int, object{value: mixed, name: string}>
     */
    public static function toValueNameObjects(): array
    {
        return array_map(
            fn($case) => (object)[
                'value' => $case->value,
                'name' => Str::title($case->name),
            ],
            self::cases()
        );
    }
    public function label(): string
    {
        return ucwords(strtolower(str_replace('_', ' ', $this->name)));
    }
}
