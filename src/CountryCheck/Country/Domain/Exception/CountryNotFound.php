<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Exception;

use CountryCheckApi\CountryCheck\Shared\Domain\Exception\DomainException;
use CountryCheckApi\CountryCheck\Shared\Domain\Exception\ExceptionCode;

final class CountryNotFound extends DomainException
{
    public function __construct(string $code)
    {
        parent::__construct(
            'Country not found',
            ExceptionCode::NotFound,
            ['code' => $code]
        );
    }
}
