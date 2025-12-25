<?php

namespace App\Traits;

trait Enums
{
    /**
     * Get a formatted list of enum values.
     */
    public static function getList(): array
    {
        $formattedValues = [];
        foreach (self::cases() as $case) {
            $formattedValues[$case->value] = [
                'name' => $case->name,
                'value' => $case->value,
                'label' => $case->label(),
            ];
        }
        return $formattedValues;
    }

    /**
     * Convert enum name to a human-readable label dynamically.
     */
    public function label(): string
    {
        return ucwords(strtolower(str_replace('_', ' ', $this->name)));
    }

    /**
     * Get an enum instance from a given value.
     */
    public static function fromValue(int|string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }
}
