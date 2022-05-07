<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Application\CheckCountry;

final class CountryStatus
{
    public function __construct(
        public readonly bool $code,
        public readonly bool $region,
        public readonly bool $population,
        public readonly bool $rival
    ) {
    }
}
