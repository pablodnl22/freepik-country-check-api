<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Application\CheckCountry;

use CountryCheckApi\CountryCheck\Shared\Application\QueryBus\Result;

final class CheckCountryResult implements Result
{
    public function __construct(
        public readonly bool $result,
        public readonly CountryStatus $criteria,
    ) {
    }
}
