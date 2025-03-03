<?php

namespace App\Traits;

trait Enums
{
    public function label(): string
    {
        // Convert enum case name to lowercase and replace underscores with spaces
        $label = strtolower(str_replace('_', ' ', $this->name));

        // Convert first letter of each word to uppercase
        return ucwords($label);
    }
}
