<?php

namespace App\Interfaces;

use App\Interfaces\BaseInterface;

interface UserInterface extends BaseInterface
{
    // Add model-specific methods here if needed
    public function isEmailAvailable(string $email, ?int $ignoreUserId = null): bool;
}
