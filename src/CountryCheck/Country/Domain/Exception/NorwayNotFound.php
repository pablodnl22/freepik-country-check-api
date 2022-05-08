<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Exception;

use CountryCheckApi\CountryCheck\Shared\Domain\Exception\DomainException;
use CountryCheckApi\CountryCheck\Shared\Domain\Exception\ExceptionCode;

final class NorwayNotFound extends DomainException
{
    public function __construct()
    {
        parent::__construct('Norway country not found', ExceptionCode::NotFound);
    }
}
