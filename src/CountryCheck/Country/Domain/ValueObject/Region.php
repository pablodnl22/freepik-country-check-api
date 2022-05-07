<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\ValueObject;

use CountryCheckApi\CountryCheck\Shared\Domain\ValueObject\StringValueObject;

final class Region extends StringValueObject
{
    private const EUROPE = 'Europe';
    private const ASIA = 'Asia';
    
    protected function __construct(string $value)
    {
        parent::__construct(ucfirst(strtolower($value)));
    }
    
    public function isAsia(): bool
    {
        return self::ASIA === $this->value();
    }

    public function isEurope(): bool
    {
        return self::EUROPE === $this->value();
    }
}
