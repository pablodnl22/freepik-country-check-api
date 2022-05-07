<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\ValueObject;

use CountryCheckApi\CountryCheck\Shared\Domain\ValueObject\StringValueObject;

final class Code extends StringValueObject
{
    protected function __construct(string $value)
    {
        parent::__construct(strtoupper($value));
    }
}
