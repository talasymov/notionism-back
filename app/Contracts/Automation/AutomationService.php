<?php

namespace App\Contracts\Automation;

use App\Models\User;

interface AutomationService
{
    public function __construct(array $config, User $user);

    public function test(): bool;
}
