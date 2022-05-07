<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Shared\Domain\ValueObject;

use JsonSerializable;
use Stringable;

abstract class IntValueObject implements JsonSerializable, Stringable
{
    private int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equalTo(IntalueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value === $other->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public static function from(int $value): static
    {
        return new static($value);
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
