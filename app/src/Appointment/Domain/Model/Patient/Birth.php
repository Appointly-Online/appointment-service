<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Patient;

use App\Shared\ValueObjectInterface;

final class Birth implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $birth;

    public function __construct(string $birth)
    {
        $this->birth = $birth;
    }

    public function toString(): string
    {
        return $this->birth;
    }

    public static function fromString(string $birth): self
    {
        return new self($birth);
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return get_class($this) === get_class($other) && $this->birth === $other->birth;
    }
}