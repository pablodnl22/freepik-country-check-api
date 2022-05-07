<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Model;

use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Code;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Population;
use CountryCheckApi\CountryCheck\Country\Domain\ValueObject\Region;

final class Country
{
    public function __construct(
        private readonly Code $code,
        private readonly Region $region,
        private readonly Population $population
    ) {
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function region(): Region
    {
        return $this->region;
    }

    public function population(): Population
    {
        return $this->population;
    }

}
