<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Appointment;

use App\Shared\ValueObjectInterface;
use function get_class;

final class Description implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function toString(): string
    {
        return $this->description;
    }

    public static function fromString(string $description): self
    {
        return new self($description);
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return get_class($this) === get_class($other) && $this->description === $other->description;
    }
}
