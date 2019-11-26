<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Appointment;

use App\Shared\ValueObjectInterface;
use function get_class;

final class Title implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function toString(): string
    {
        return $this->title;
    }

    public static function fromString(string $title): self
    {
        return new self($title);
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return get_class($this) === get_class($other) && $this->title === $other->title;
    }
}
