<?php

declare(strict_types=1);

namespace App\Shared;

interface ValueObjectInterface
{
    public function sameValueAs(ValueObjectInterface $other): bool;
}
