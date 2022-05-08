<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\ValueObject;

use CountryCheckApi\CountryCheck\Shared\Domain\Exception\DomainException;
use CountryCheckApi\CountryCheck\Shared\Domain\Exception\ExceptionCode;
use CountryCheckApi\CountryCheck\Shared\Domain\ValueObject\StringValueObject;

final class Code extends StringValueObject
{
    protected function __construct(string $value)
    {
        $length = strlen($value);
        if ($length < 2 || $length > 3) {
            throw new DomainException(
                'Invalid country code',
                ExceptionCode::BadBusinessLogic,
                ['code' => $value]
            );
        }

        parent::__construct(strtoupper($value));
    }
}
