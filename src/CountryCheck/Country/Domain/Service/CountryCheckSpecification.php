<?php

declare(strict_types=1);

namespace CountryCheckApi\CountryCheck\Country\Domain\Service;

use CountryCheckApi\CountryCheck\Country\Domain\Model\Country;

interface CountryCheckSpecification
{
    public function valid(Country $country, CountryCheckingResult $checkingResult): CountryCheckingResult;
}
