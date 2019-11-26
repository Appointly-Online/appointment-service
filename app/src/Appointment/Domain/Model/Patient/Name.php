<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Patient;

use App\Shared\ValueObjectInterface;

final class Name implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return get_class($this) === get_class($other) && $this->name === $other->name;
    }
}
